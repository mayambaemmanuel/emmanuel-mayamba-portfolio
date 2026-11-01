<?php
require __DIR__ . '/bootstrap.php';
// Page wording and image references come from MySQL; HTML controls the layout.
$content = [];
$rows = db()->query('SELECT content_key, content_value FROM portfolio_content');
foreach ($rows as $row) $content[$row['content_key']] = $row['content_value'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="The personal portfolio of Emmanuel Mayamba." />
    <title><?= e($content['emmanuel_mayamba_portfolio']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <script id="learning-topics" type="application/json"><?= json_encode(json_decode($content['learning_topics'], true), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
    <script src="script.js" defer></script>
  </head>
  <body>
    <a class="skip-link" href="#main-content"><?= e($content['skip_to_main_content']) ?></a>
    <header class="site-header">
      <nav class="container navigation" aria-label="Main navigation">
        <a class="logo" href="#home" aria-label="Emmanuel Mayamba home"><?= e($content['em']) ?><span><?= e($content['symbol']) ?></span></a>
        <button class="menu-toggle" type="button" aria-controls="navigation-links" aria-expanded="false" hidden><span aria-hidden="true"><?= e($content['symbol_2']) ?></span> <span class="menu-label"><?= e($content['menu']) ?></span></button>
        <ul class="nav-links" id="navigation-links">
          <li><a href="#about"><?= e($content['about']) ?></a></li>
          <li><a href="#skills"><?= e($content['skills']) ?></a></li>
          <li><a href="#projects"><?= e($content['projects']) ?></a></li>
          <li><a href="#contact"><?= e($content['contact']) ?></a></li>
        <?php if (user_id()): ?>
          <li><a href="dashboard.php">My account</a></li>
          <?php else: ?>
          <li><a href="account.php">Log in</a></li>
          <li><a href="account.php?mode=register">Register</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>

    <main id="main-content">
      <section class="hero" id="home">
        <div class="container hero-grid">
          <div class="hero-copy">
            <p class="eyebrow"><?= e($content['student_aspiring_web_developer']) ?></p>
            <h1><?= e($content['emmanuel']) ?><br /><span><?= e($content['mayamba']) ?></span></h1>
            <p class="intro"><?= e($content['i_am_a_student_and_an_aspiring_web_developer_who_enjoys']) ?></p>
            <div class="hero-actions">
              <a class="button button-primary" href="#projects"><?= e($content['view_my_work']) ?></a>
              <a class="text-link" href="#contact"><?= e($content['let_s_connect']) ?><span aria-hidden="true"><?= e($content['symbol_3']) ?></span></a>
            </div>
            <div class="hero-footnote"><span><?= e($content['01_introduction']) ?></span><span><?= e($content['curiosity_craft_progress']) ?></span></div>
          </div>
          <figure class="hero-portrait">
            <img src="<?= e($content['portrait_path']) ?>" alt="Emmanuel Mayamba standing at a wooden lectern" width="800" height="1066" fetchpriority="high" />
            <figcaption><span><?= e($content['emmanuel_mayamba']) ?></span><span><?= e($content['learning_building']) ?></span></figcaption>
          </figure>
        </div>
      </section>

      <section class="section" id="about">
        <div class="container about-grid">
          <div><p class="eyebrow"><?= e($content['a_little_about_me']) ?></p><h2><?= e($content['building_skills_one_project_at_a_time']) ?></h2></div>
          <div class="about-content">
            <p><?= e($content['i_am_emmanuel_mayamba_a_curious_learner_with_an_interes']) ?></p>
            <p><?= e($content['this_portfolio_is_a_collection_of_my_learning_journey_c']) ?></p>
            <div class="learning-focus" hidden>
              <p class="eyebrow"><?= e($content['learning_focus']) ?></p>
              <p id="focus-content" aria-live="polite"></p>
              <button class="button button-primary" id="next-focus" type="button"><?= e($content['explore_another_focus']) ?></button>
            </div>
          </div>
        </div>
      </section>

      <section class="section section-tint" id="skills">
        <div class="container">
          <p class="eyebrow"><?= e($content['what_i_m_learning']) ?></p><h2><?= e($content['my_current_skill_set']) ?></h2>
          <div class="skills-grid">
            <article class="skill-card"><span class="skill-icon" aria-hidden="true"><?= e($content['symbol_4']) ?></span><h3><?= e($content['html']) ?></h3><p><?= e($content['creating_meaningful_page_structure_with_clean_semantic_']) ?></p></article>
            <article class="skill-card"><span class="skill-icon" aria-hidden="true"><?= e($content['symbol_5']) ?></span><h3><?= e($content['css']) ?></h3><p><?= e($content['designing_responsive_layouts_with_colour_spacing_and_ty']) ?></p></article>
            <article class="skill-card"><span class="skill-icon" aria-hidden="true"><?= e($content['symbol_6']) ?></span><h3><?= e($content['problem_solving']) ?></h3><p><?= e($content['breaking_down_challenges_and_building_practical_solutio']) ?></p></article>
          </div>
        </div>
      </section>

      <section class="section" id="projects">
        <div class="container">
          <div class="section-heading"><div><p class="eyebrow"><?= e($content['selected_work']) ?></p><h2><?= e($content['projects_coursework']) ?></h2></div><p><?= e($content['more_projects_will_be_added_here_as_my_portfolio_grows']) ?></p></div>
          <div class="projects-grid">
            <article class="project-card featured-project">
              <div class="project-number"><?= e($content['01']) ?></div>
              <div><p class="project-label"><?= e($content['web_design']) ?></p><h3><?= e($content['personal_portfolio_website']) ?></h3><p><?= e($content['a_responsive_website_that_introduces_who_i_am_the_skill']) ?></p><ul class="tag-list" aria-label="Technologies used"><li><?= e($content['html']) ?></li><li><?= e($content['css']) ?></li><li><?= e($content['responsive_design']) ?></li></ul></div>
            </article>
            <article class="project-card upcoming-project">
              <div class="project-number"><?= e($content['02']) ?></div>
              <div><p class="project-label"><?= e($content['coming_soon']) ?></p><h3><?= e($content['next_learning_project']) ?></h3><p><?= e($content['i_m_currently_exploring_new_ideas_and_will_add_another_']) ?></p></div>
            </article>
          </div>
        </div>
      </section>

      <section class="contact-section" id="contact">
        <div class="container contact-content">
          <p class="eyebrow"><?= e($content['get_in_touch']) ?></p><h2><?= e($content['let_s_create_something_meaningful']) ?></h2>
          <p><?= e($content['have_a_question_or_would_like_to_discuss_a_project_i_wo']) ?></p>
          <a class="button button-light" href="mailto:<?= e($content['contact_email']) ?>"><?= e($content['send_me_an_email']) ?></a>
          <form id="contact-form" class="contact-form" action="contact.php" method="post" hidden>
            <?= csrf_input() ?>
            <p id="form-help">All fields are required. Messages are saved to the portfolio database. <?php if (!user_id()): ?><a class="text-link" href="account.php">Log in</a> or <a class="text-link" href="account.php?mode=register">register</a> to send a message.<?php else: ?>View your messages in <a class="text-link" href="dashboard.php">My account</a>.<?php endif; ?></p>
            <label for="contact-name"><?= e($content['your_name']) ?></label>
            <input id="contact-name" name="name" autocomplete="name" required maxlength="100" aria-describedby="name-error" />
            <p class="field-error" id="name-error"></p>
            <label for="contact-email"><?= e($content['email_address']) ?></label>
            <input id="contact-email" name="email" type="email" autocomplete="email" required maxlength="254" aria-describedby="email-error" />
            <p class="field-error" id="email-error"></p>
            <label for="contact-message"><?= e($content['message']) ?></label>
            <textarea id="contact-message" name="message" rows="5" required maxlength="2000" aria-describedby="message-error"></textarea>
            <p class="field-error" id="message-error"></p>
            <button class="button button-light" type="submit">Send message</button>
            <p id="form-status" role="status" aria-live="polite"></p>
          </form>
          <noscript><p><?= e($content['please_use_the_email_link_to_get_in_touch_enable_javasc']) ?></p></noscript>
        </div>
      </section>
    </main>

    <footer class="site-footer"><div class="container footer-content"><a class="logo" href="#home" aria-label="Back to top"><?= e($content['em']) ?><span><?= e($content['symbol']) ?></span></a><p><?= e($content['symbol_7']) ?><span id="current-year"><?= e($content['2026']) ?></span><?= e($content['emmanuel_mayamba_built_with_html_css_javascript']) ?></p><a href="#home"><?= e($content['back_to_top']) ?></a></div></footer>
  </body>
</html>
