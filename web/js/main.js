(function () {
  "use strict";

  function $(selector, root) {
    return (root || document).querySelector(selector);
  }
  function $all(selector, root) {
    return Array.prototype.slice.call((root || document).querySelectorAll(selector));
  }

  var toastTimer = null;
  function showToast(text) {
    var toast = $("#toast");
    if (!toast) return;
    toast.textContent = text;
    toast.classList.add("is-visible");
    window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(function () {
      toast.classList.remove("is-visible");
    }, 2200);
  }

  var storage = {
    get: function (key, fallback) {
      try {
        var raw = window.localStorage.getItem(key);
        return raw === null ? fallback : JSON.parse(raw);
      } catch (e) {
        return fallback;
      }
    },
    set: function (key, value) {
      try {
        window.localStorage.setItem(key, JSON.stringify(value));
      } catch (e) {

      }
    }
  };

  function initNav() {
    var button = $("[data-nav-toggle]");
    var nav = $("#main-nav");
    if (!button || !nav) return;

    function setOpen(open) {
      nav.classList.toggle("is-open", open);
      button.setAttribute("aria-expanded", open ? "true" : "false");
      button.setAttribute("aria-label", open ? "Закрыть меню" : "Открыть меню");
    }

    button.addEventListener("click", function () {
      setOpen(!nav.classList.contains("is-open"));
    });
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && nav.classList.contains("is-open")) {
        setOpen(false);
        button.focus();
      }
    });
    window.addEventListener("resize", function () {
      if (window.innerWidth >= 768) setOpen(false);
    });
  }

  var FAV_KEY = "polka:favorites";
  var DEFAULT_FAVS = ["master", "hawking", "prince"];

  function getFavs() {
    var list = storage.get(FAV_KEY, DEFAULT_FAVS);
    return Array.isArray(list) ? list : DEFAULT_FAVS.slice();
  }

  function renderFavs() {
    var favs = getFavs();
    $all("[data-fav]").forEach(function (el) {
      var on = favs.indexOf(el.getAttribute("data-fav")) !== -1;
      el.setAttribute("aria-pressed", on ? "true" : "false");
      var label = $("[data-fav-label]", el);
      if (label) label.textContent = on ? "В избранном" : "В избранное";
    });
  }

  function initFavorites() {
    renderFavs();
    document.addEventListener("click", function (event) {
      var el = event.target.closest ? event.target.closest("[data-fav]") : null;
      if (!el) return;
      var id = el.getAttribute("data-fav");
      var favs = getFavs();
      var index = favs.indexOf(id);
      if (index === -1) {
        favs.push(id);
        showToast("Добавлено в избранное");
      } else {
        favs.splice(index, 1);
        showToast("Убрано из избранного");
      }
      storage.set(FAV_KEY, favs);
      renderFavs();
    });
  }

  function initRating() {
    var group = $("[data-rating]");
    if (!group) return;
    var buttons = $all("button", group);
    var output = $("[data-rating-output]");
    var value = parseInt(group.getAttribute("data-rating"), 10) || 0;

    function draw() {
      buttons.forEach(function (btn, i) {
        var n = i + 1;
        btn.classList.toggle("is-on", n <= value);
        btn.setAttribute("aria-checked", n === value ? "true" : "false");
        btn.tabIndex = n === value || (value === 0 && i === 0) ? 0 : -1;
      });
      if (output) output.textContent = value ? value + ".0" : "—";
    }

    function select(n, announce) {
      value = n;
      draw();
      if (announce) showToast("Оценка сохранена");
    }

    buttons.forEach(function (btn, i) {
      btn.addEventListener("click", function () {
        select(i + 1, true);
      });
      btn.addEventListener("keydown", function (event) {
        var next = null;
        if (event.key === "ArrowRight" || event.key === "ArrowUp") next = Math.min(i + 1, buttons.length - 1);
        if (event.key === "ArrowLeft" || event.key === "ArrowDown") next = Math.max(i - 1, 0);
        if (next !== null) {
          event.preventDefault();
          select(next + 1, false);
          buttons[next].focus();
        }
      });
    });
    draw();
  }

  function initReadToggle() {
    var toggle = $("#read-toggle");
    if (!toggle) return;
    var sub = $("#read-sub");
    var badge = $("[data-status-badge]");

    toggle.addEventListener("change", function () {
      var read = toggle.checked;
      if (sub) {
        sub.textContent = read
          ? "Отмечено " + new Date().toLocaleDateString("ru-RU")
          : "Пока в планах";
      }
      if (badge) {
        badge.textContent = read ? "Прочитано" : "В планах";
        badge.className = "badge " + (read ? "badge--read" : "badge--want");
      }
    });
  }

  function initNotes() {
    var list = $("[data-notes-list]");
    var form = $("[data-note-form]");
    if (!list || !form) return;

    var textarea = $("textarea", form);
    var field = $(".field", form);
    var error = $("[data-note-error]", form);
    var counter = $("[data-note-counter]", form);

    function refreshCount() {
      var count = $all(".note", list).length;
      $all("[data-notes-count]").forEach(function (el) {
        el.textContent = String(count);
      });
      var empty = $("[data-notes-empty]");
      if (empty) empty.hidden = count > 0;
    }

    list.addEventListener("click", function (event) {
      var btn = event.target.closest ? event.target.closest("[data-note-delete]") : null;
      if (!btn) return;
      var note = btn.closest(".note");
      if (note) note.parentNode.removeChild(note);
      refreshCount();
      showToast("Заметка удалена");
    });

    textarea.addEventListener("input", function () {
      if (counter) counter.textContent = String(textarea.value.length);
      if (textarea.value.trim()) {
        field.classList.remove("has-error");
        error.hidden = true;
        textarea.removeAttribute("aria-invalid");
      }
    });

    form.addEventListener("submit", function (event) {
      event.preventDefault();
      var text = textarea.value.trim();
      if (!text) {
        field.classList.add("has-error");
        error.hidden = false;
        textarea.setAttribute("aria-invalid", "true");
        textarea.focus();
        return;
      }
      var now = new Date();
      var li = document.createElement("li");
      li.className = "note";

      var head = document.createElement("div");
      head.className = "note__head";
      var time = document.createElement("time");
      time.className = "note__date";
      time.setAttribute("datetime", now.toISOString().slice(0, 10));
      time.textContent = now.toLocaleDateString("ru-RU");
      var del = document.createElement("button");
      del.className = "link-btn";
      del.type = "button";
      del.setAttribute("data-note-delete", "");
      del.textContent = "Удалить";
      head.appendChild(time);
      head.appendChild(del);

      var p = document.createElement("p");
      p.textContent = text;

      li.appendChild(head);
      li.appendChild(p);
      list.insertBefore(li, list.firstChild);

      textarea.value = "";
      if (counter) counter.textContent = "0";
      refreshCount();
      showToast("Заметка сохранена");
    });

    refreshCount();
  }

  function initBookDelete() {
    var btn = $("[data-book-delete]");
    if (!btn) return;
    btn.addEventListener("click", function () {
      if (window.confirm("Удалить книгу?")) showToast("Книга удалена (демо)");
    });
  }

  function initProfile() {
    var form = $("[data-profile-form]");
    if (!form) return;

    var READ_COUNT = parseInt(form.getAttribute("data-read-count"), 10) || 0;
    var name = $("#profile-name");
    var email = $("#profile-email");
    var goal = $("#profile-goal");
    var bar = $("[data-goal-bar]");
    var meter = $("[data-goal-meter]");
    var text = $("[data-goal-text]");

    function drawGoal() {
      var g = Math.max(1, parseInt(goal.value, 10) || 1);
      var percent = Math.min(100, Math.round((READ_COUNT / g) * 100));
      bar.style.width = percent + "%";
      meter.setAttribute("aria-valuenow", String(Math.min(READ_COUNT, g)));
      meter.setAttribute("aria-valuemax", String(g));
      text.textContent =
        "Прочитано " + READ_COUNT + " из " + g +
        (g > READ_COUNT ? " · осталось " + (g - READ_COUNT) : " · цель достигнута");
    }

    function setError(input, message) {
      var field = input.closest(".field");
      var err = $("[data-error]", field);
      field.classList.toggle("has-error", Boolean(message));
      err.hidden = !message;
      if (message) {
        err.textContent = message;
        input.setAttribute("aria-invalid", "true");
      } else {
        input.removeAttribute("aria-invalid");
      }
      return !message;
    }

    function validate() {
      var emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim());
      var a = setError(name, name.value.trim().length < 2 ? "Введите имя (минимум 2 символа)" : "");
      var b = setError(email, emailOk ? "" : "Введите корректный email");
      var c = setError(goal, parseInt(goal.value, 10) >= 1 ? "" : "Цель — число не меньше 1");
      return a && b && c;
    }

    goal.addEventListener("input", drawGoal);
    form.addEventListener("submit", function (event) {
      if (!validate()) {
        event.preventDefault();
        var bad = $("[aria-invalid]", form);
        if (bad) bad.focus();
      }
    });

    $all("[data-focus-target]").forEach(function (el) {
      el.addEventListener("click", function () {
        var target = $(el.getAttribute("data-focus-target"));
        if (target) {
          target.scrollIntoView({ behavior: "smooth", block: "center" });
          target.focus();
        }
      });
    });

    var logout = $("[data-logout]");
    if (logout) {
      logout.addEventListener("click", function () {
        showToast("Выход выполнен (демо)");
      });
    }
    drawGoal();
  }

  function initFilter() {
    var group = $("[data-filter]");
    var list = $("[data-books-list]");
    if (!group || !list) return;
    var buttons = $all("[data-filter-value]", group);
    var items = $all("li[data-status]", list);
    var empty = $("[data-books-empty]");
    var counter = $("[data-books-count]");

    buttons.forEach(function (btn) {
      btn.addEventListener("click", function () {
        var value = btn.getAttribute("data-filter-value");
        var shown = 0;
        buttons.forEach(function (b) {
          var on = b === btn;
          b.classList.toggle("is-active", on);
          b.setAttribute("aria-pressed", on ? "true" : "false");
        });
        items.forEach(function (li) {
          var ok = value === "all" || li.getAttribute("data-status") === value;
          li.hidden = !ok;
          if (ok) shown += 1;
        });
        if (empty) empty.hidden = shown > 0;
        if (counter) counter.textContent = String(shown);
      });
    });
  }

  function initAuth() {
    var tabs = $all("[data-tab]");
    if (!tabs.length) return;

    function select(name, focus) {
      tabs.forEach(function (tab) {
        var on = tab.getAttribute("data-tab") === name;
        tab.setAttribute("aria-selected", on ? "true" : "false");
        tab.tabIndex = on ? 0 : -1;
        $("#panel-" + tab.getAttribute("data-tab")).hidden = !on;
        if (on && focus) tab.focus();
      });
    }

    tabs.forEach(function (tab, i) {
      tab.addEventListener("click", function () {
        select(tab.getAttribute("data-tab"), false);
      });
      tab.addEventListener("keydown", function (event) {
        var next = null;
        if (event.key === "ArrowRight") next = (i + 1) % tabs.length;
        if (event.key === "ArrowLeft") next = (i - 1 + tabs.length) % tabs.length;
        if (next !== null) {
          event.preventDefault();
          select(tabs[next].getAttribute("data-tab"), true);
        }
      });
    });

    $all("[data-switch-tab]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        select(btn.getAttribute("data-switch-tab"), false);
      });
    });

    if (window.location.hash === "#register") select("register", false);

    $all("[data-toggle-password]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        var input = document.getElementById(btn.getAttribute("aria-controls"));
        var show = input.type === "password";
        input.type = show ? "text" : "password";
        btn.textContent = show ? "Скрыть" : "Показать";
        btn.setAttribute("aria-label", show ? "Скрыть пароль" : "Показать пароль");
      });
    });

    function setError(input, message) {
      var field = input.closest(".field");
      var err = $("[data-error]", field);
      field.classList.toggle("has-error", Boolean(message));
      err.hidden = !message;
      err.textContent = message || "";
      if (message) {
        input.setAttribute("aria-invalid", "true");
      } else {
        input.removeAttribute("aria-invalid");
      }
      return !message;
    }

    function validEmail(value) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
    }

    function validators(kind) {
      var f = function (id) { return document.getElementById(id); };
      var rule = function (id, test, message) {
        var fn = function () { return setError(f(id), test(f(id)) ? "" : message); };
        fn.el = f(id);
        return fn;
      };
      var email = function (el) { return validEmail(el.value); };
      if (kind === "login") {
        return [
          rule("login-email", email, "Введите корректный email"),
          rule("login-password", function (el) { return el.value; }, "Введите пароль")
        ];
      }
      return [
        rule("reg-name", function (el) { return el.value.trim().length >= 2; }, "Введите имя (минимум 2 символа)"),
        rule("reg-lastname", function (el) { return el.value.trim().length >= 1; }, "Введите фамилию"),
        rule("reg-email", email, "Введите корректный email"),
        rule("reg-password", function (el) {
          return el.value.length >= 8 && /[A-Za-zА-Яа-яЁё]/.test(el.value) && /\d/.test(el.value);
        }, "Минимум 8 символов, буква и цифра"),
        rule("reg-password2", function (el) {
          return el.value !== "" && el.value === f("reg-password").value;
        }, "Пароли не совпадают"),
        rule("reg-agree", function (el) { return el.checked; }, "Нужно ваше согласие")
      ];
    }

    $all("[data-auth-form]").forEach(function (form) {
      var kind = form.getAttribute("data-auth-form");
      var checks = validators(kind);

      $all("input", form).forEach(function (input) {
        input.addEventListener("input", function () {
          checks.forEach(function (c) {
            if (c.el.getAttribute("aria-invalid")) c();
          });
        });
      });

      form.addEventListener("submit", function (event) {
        var ok = true;
        checks.forEach(function (check) {
          if (!check()) ok = false;
        });
        if (!ok) {
          event.preventDefault();
          var bad = $("[aria-invalid]", form);
          if (bad) bad.focus();
        }
      });
    });
  }

  function initAddBook() {
    var form = $("[data-add-form]");
    if (!form) return;

    var title = $("#book-title");
    var author = $("#book-author");
    var genre = $("#book-genre");
    var year = $("#book-year");
    var pages = $("#book-pages");
    var ratingField = $("[data-rating-field]", form);

    function preview() {
      var t = title.value.trim() || "Название книги";
      $("[data-preview-title]").textContent = t;
      $("[data-preview-name]").textContent = t;
      $("[data-preview-author]").textContent = author.value.trim() || "Автор";
      $("[data-preview-genre]").textContent = genre.value ? genre.options[genre.selectedIndex].text : "Жанр";
    }
    form.addEventListener("input", preview);
    form.addEventListener("change", function () {
      preview();
      var status = $("input[name=status]:checked", form).value;
      ratingField.hidden = status !== "read";
    });

    function setError(input, message) {
      var field = input.closest(".field");
      var err = $("[data-error]", field);
      field.classList.toggle("has-error", Boolean(message));
      err.hidden = !message;
      err.textContent = message || "";
      if (message) {
        input.setAttribute("aria-invalid", "true");
      } else {
        input.removeAttribute("aria-invalid");
      }
      return !message;
    }

    var maxYear = new Date().getFullYear() + 1;
    var checks = [
      function () { return setError(title, title.value.trim() ? "" : "Введите название книги"); },
      function () { return setError(author, author.value.trim() ? "" : "Введите автора"); },
      function () { return setError(genre, genre.value ? "" : "Выберите жанр"); },
      function () {
        var y = parseInt(year.value, 10);
        return setError(year, !year.value || (y >= 1000 && y <= maxYear) ? "" : "Год от 1000 до " + maxYear);
      },
      function () {
        var n = parseInt(pages.value, 10);
        return setError(pages, !pages.value || (n >= 1 && n <= 9999) ? "" : "Страниц от 1 до 9999");
      }
    ];
    var inputs = [title, author, genre, year, pages];

    inputs.forEach(function (input, i) {
      input.addEventListener("input", function () {
        if (input.getAttribute("aria-invalid")) checks[i]();
      });
      input.addEventListener("change", function () {
        if (input.getAttribute("aria-invalid")) checks[i]();
      });
    });

    form.addEventListener("submit", function (event) {
      var ok = true;
      checks.forEach(function (check) {
        if (!check()) ok = false;
      });
      if (!ok) {
        event.preventDefault();
        var bad = $("[aria-invalid]", form);
        if (bad) bad.focus();
      }
    });
    preview();
  }

  function initPlaceholders() {
    $all('a[href="#"]').forEach(function (a) {
      a.addEventListener("click", function (event) {
        event.preventDefault();
        showToast("Эта страница ещё не готова");
      });
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    initNav();
    initFavorites();
    initRating();
    initReadToggle();
    initNotes();
    initBookDelete();
    initProfile();
    initFilter();
    initAuth();
    initAddBook();
    initPlaceholders();
  });
})();
