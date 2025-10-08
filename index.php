<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Borodinski — Barbershop</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
require_once 'config.php';
?>
  <header class="site-header" role="banner">
    <div class="container topbar" aria-hidden="false">
      <!-- Основная навигация -->
      <nav class="nav-center" role="navigation" aria-label="Главное меню">
        <strong>
        <a href="">Информация</a>
        <a href="products/news.php">Новости</a>
        <a href="price/price.php">Прайс-лист</a>
        <a href="catalog/catalog2.php">Магазин</a>
        <a href="products/contacts.php">Контакты</a></strong>
      </nav>
      <!-- Блок авторизации -->
      <div class="login">
        <?php if (isLoggedIn()): ?>
          <span style="color: #fff;">
            <?php echo htmlspecialchars($_SESSION['user']); ?>
            <?php if (isAdmin()): ?>
              <a href="admin/admin.php" style="color: #ffd700; margin-left: 1rem;">Админ</a>
            <?php else: ?>
              <a href="cart.php" style="margin-left: 1rem; color: #fff;">Корзина</a>
            <?php endif; ?>
            <a href="auth/logout.php" style="margin-left: 1rem; color: #fff;">Выйти</a>
          </span>
        <?php else: ?>
          <a href="auth/login.php" title="Вход" style="display:inline-flex;gap:.5rem;align-items:center;">
            <img src="img/login.svg" alt="" class="log1"> ВХОД
          </a>
        <?php endif; ?>
      </div>
    </div>
    <!-- Секция  -->
    <section class="hero" role="img" aria-label="Барбершоп фон">
      <div class="hero__bg" aria-hidden="true"><img src="img/bg.jpg" alt="" class="bgc"></div>
      <div class="hero__overlay" aria-hidden="true"></div>
      <div class="hero-inner container">
        <!-- Логотип -->
        <div class="brand" role="img" aria-label="Логотип Borodinski">
            <img src="img/index-logo.svg" alt="логотип" class="logo">
        </div>
        <!-- Преимущества -->
        <div class="features" role="region" aria-label="Преимущества">
          <div class="feature">
            <h3>БЫСТРО</h3>
            <img src="img/rom.png" alt="" class="rom rom1"> 
            <p>МЫ ДЕЛАЕМ СВОЮ РАБОТУ БЫСТРО! ДВА ЧАСА <br>ПРОЛЕТЯТ НЕЗАМЕТНО И ВЫ — СЧАСТЛИВЫЙ <br> ОБЛАДАТЕЛЬ СТИЛЬНОЙ СТРИЖКИ-МИНУТКИ.</p>
          </div>
          <div class="feature">
            <h3>КРУТО</h3>
            <img src="img/rom.png" alt="" class="rom rom1"> 
            <p>Забудьте, как вы стриглись раньше.<br> Мы сделаем из вас звезду футбола или кино! <br> во всяком случае внешне.</p>
          </div>
          <div class="feature">
            <h3>ДОРОГО</h3>
            <img src="img/rom.png" alt="" class="rom rom1"> 
            <p>Наши мастера — профессионалы своего дела и <br> не могут стоить дешево. К тому же, разве цена<br> не даёт определённый статус?</p>
          </div>
        </div>
      </div>
    </section>
  </header>
  <main role="main">
    <div class="cards-wrap container">
      <!-- Новости и галерея -->
      <section class="card news-gallery" aria-labelledby="newsTitle">
        <article class="card news-list" aria-labelledby="newsTitle">
          <h2 id="newsTitle">Новости</h2>
          <p>Нам наконец завезли ЯГЕРМЕЙСТЕР! Теперь вы можете пропустить стаканчик во время стрижки.<br> 11 января</p>
          <p>В нашей команде пополнение, Борис «Бритва» Стригунец. Обладатель множества титулов и наград пополнил наши стройные ряды.<br> 18 января</p>
          <a class="btn" href="#" title="Все новости">Все новости</a>
        </article>
        <aside class="gallery" aria-labelledby="galleryTitle">
            <h2 id="galleryTitle">Фотогалерея</h2>
            <div class="slider-container">
                <img class="thumb" id="galleryImage" src="img/inter.jpg" alt="Интерьер барбершопа — пример 1">
                <div class="controls" aria-hidden="false">
                    <button id="prevBtn" aria-label="Назад" title="Назад">Назад</button>
                    <button id="nextBtn" aria-label="Вперед" title="Вперед">Вперед</button>
                </div>
            </div>
        </aside>
      </section>
      <!-- Контакты и запись -->
      <section class="card-grid" aria-label="Контакты и запись">
        <div class="card contact" role="region" aria-labelledby="contactTitle">
          <h2 id="contactTitle" style="margin-left: 2rem;">Контактная информация</h2>
          <p>Барбершоп «Бородинский»</p>
          <p>Адрес: г. Санкт-Петербург, ул. К. Комсомольская д. 19/8</p>
          <p>Телефон: +7 (495) 666-02-66</p>
          <p>Время работы:</p>
          <p>Пн-Пт: 10:00 — 22:00<br>Сб-Вс: 10:00 — 19:00</p>
          <div style="margin-top:1rem; display:flex; gap:.6rem; flex-wrap:wrap;margin-left: 2rem;">
            <a class="btn" href="Вот так как то">Как проехать</a>
            <a class="btn" href="Звонок скам" style="color:#ffffff;border:1px solid rgba(0,0,0,0.06)">Обратная связь</a>
          </div>
        </div>
        <!-- Форма -->
        <aside class="card booking" role="region" aria-labelledby="bookingTitle">
          <h2 id="bookingTitle">Записаться</h2>
          <p>Укажите желаемую дату и время и мы свяжемся с вами для подтверждения брони.</p>
          <form id="bookingForm" onsubmit="return false;" aria-label="Форма записи">
            <div class="form-row">
              <div class="field">
                <label for="date">Дата</label>
                <input type="date" placeholder="08.10.2017" id="date" required />
              </div>
              <div class="field">
                <label for="time">Время</label>
                <input type="time" id="time" required />
              </div>
            </div>
            <div class="form-row" style="margin-top:.6rem;">
              <div class="field">
                <label for="name">Ваше имя</label>
                <input type="text" id="name" placeholder="Борода" required />
              </div>
              <div class="field">
                <label for="phone">Телефон</label>
                <input type="tel" id="phone" placeholder="+7 123 456-78-90" required />
              </div>
            </div>

            <button class="submit" id="submitBooking" type="submit">Отправить</button>
          </form>
        </aside>
      </section>
    </div>
  </main>
  <!-- Подвал -->
  <footer class="site-footer" role="contentinfo">
    <div class="footer-inner">
      <div class="footer-grid">
        <div>
          <strong style="color:#fff">Барбершоп «Бородинский»</strong>
          <p style="margin:.4rem 0 0 0">Адрес: г. Санкт-Петербург, ул. К. Комсомольская, д. 19/6</p>
          <a href="#" class="gps">Как нас найти?</a>
          <p style="margin:.2rem 0 0 0">Телефон: +7 (495) 666-02-66</p>
        </div>
        <div style="text-align:center">
          <p style="color:#fff; margin:0 0 .4rem 0">Давайте дружить</p>
          <div class="socials" role="navigation" aria-label="Социальные сети">
            <a href="#" title="VK"><img src="img/vk.svg" alt=""></a>
            <a href="#" title="Facebook"><img src="img/facebook.svg" alt=""></a>
            <a href="#" title="Instagram"><img src="img/instagram.svg" alt=""></a>
          </div>
        </div>
        <div style="text-align:right">
          <p style="margin:0 0 .4rem 0">Разработано:</p>
          <a class="btn" href="#" style="background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--muted)">HTML Academy</a>
        </div>
      </div>
    </div>
  </footer>
  <script src="js/script.js"></script><!-- Подключение скриптов -->
</body>
</html>