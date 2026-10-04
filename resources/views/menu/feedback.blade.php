<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Feedback</title>

  <link rel="icon" type="image/png" href="assets/images/headlogo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #817D75;
      margin: 0;
      font-family: Arial, sans-serif;
      padding-top: 80px;
      padding-bottom: 80px;
    }

    .custom-header {
      background-color: #817D75;
      height: 80px;
      display: flex;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }

    .custom-header .navbar {
      height: 80px;
      padding: 0 15px;
      display: flex;
      align-items: center;
      width: 100%;
    }

    .lang-selector-btn {
      background-color: #EDECE7;
      color: #000;
      border: none;
      font-weight: 500;
      padding: 5px 10px;
      border-radius: 8px;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .header-title {
      color: white;
      text-align: center;
      margin: 20px 0;
      font-size: 1.5rem;
      font-weight: 600;
    }

    .dropdown-menu {
      background-color: #121212;
    border-radius: 8px;
    border: none;
    width: auto;          /* Let width adjust automatically */
    min-width: 100px;     /* Optional: prevent it from being too small */
    white-space: nowrap;
    }

    .dropdown-menu .dropdown-item {
      color: white !important;
      font-size: 1rem;
      padding: 10px 20px;
      text-align: right;
      line-height: 1.2;
    }

    .dropdown-menu .dropdown-item:hover,
    .dropdown-menu .dropdown-item:focus {
      background-color: #333 !important;
      color: white !important;
    }

    .feedback-wrap {
      display: grid;
      gap: 12px;
      margin-top: 10px;
    }

    .feedback-section, .contact-section {
      background-color: #e9e0d1;
      border-radius: 6px;
      margin: 0 15px 10px;
      padding: 20px 10px;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .category-label, .section-label {
      font-weight: 600;
      color: #254034;
      font-size: 1rem;
      margin-bottom: 12px;
    }

    .stars {
      display: inline-flex;
      gap: 14px;
      justify-content: center;
      align-items: center;
      user-select: none;
      flex-wrap: wrap;
    }

    .star {
      font-size: 40px;
      line-height: 1;
      color: #254034;
      background: none;
      border: none;
      cursor: pointer;
      transition: transform 0.2s, color 0.2s;
    }

    .star:hover {
      transform: scale(1.2);
    }

    .star.active {
      color: #FFD700;
    }

    .emoji-group {
      display: inline-flex;
      gap: 14px;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      user-select: none;
    }

    .emoji-feedback {
      font-size: 25px;
      cursor: pointer;
      padding: 5px 12px;
      filter: grayscale(100%);
      opacity: 0.6;
      border: none;
      background: none;
      transition: all 0.2s ease-in-out;
    }

    .emoji-feedback:hover,
    .emoji-feedback.selected {
      transform: scale(1.3);
      filter: grayscale(0%);
      opacity: 1;
    }

    .contact-sections-wrap {
      display: grid;
      gap: 12px;
      margin-top: 10px;
    }

    .contact-section {
      margin-bottom: 0;
    }

    .contact-section input,
    .contact-section textarea {
      width: 90%;
      border: none;
      background-color: transparent;
      outline: none;
      font-size: 1rem;
      font-weight: 600;
      text-align: center;
      color: #254034;
      margin: 0 auto;
      resize: none;
      min-height: 50px;
      padding: 15px 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .contact-section input::placeholder,
    .contact-section textarea::placeholder {
      color: #ADB0A1;
      font-weight: normal;
      text-align: center;
    }

    .contact-section textarea {
      line-height: 1.4;
      overflow-y: auto;
    }

    .btn-send {
      background-color: #F0E7D8;
      color: #254034;
      font-weight: 700;
      font-size: 1.1rem;
      border: none;
      height: 50px;
      cursor: pointer;
      user-select: none;
      transition: all 0.3s ease;
      display: flex;
      justify-content: center;
      align-items: center;
      position: fixed;
      bottom: 20px;
      left: 15px;
      right: 15px;
      border-radius: 12px;
      z-index: 1000;
      box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    }

    .btn-send:hover {
      background-color: #c6bda8;
      color: #254034;
    }

    .btn-send:disabled {
      background-color: #d1c9b8;
      color: #7a8c7c;
      cursor: not-allowed;
    }

    .confirmation-message {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #e9e0d1;
      color: #254034;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
      text-align: center;
      z-index: 2000;
      display: none;
    }

    .confirmation-message button {
      background-color: #254034;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      margin-top: 15px;
      cursor: pointer;
    }

    .error-message {
      color: #d9534f;
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
    }

    .validation-error {
      border-bottom: 2px solid #d9534f !important;
    }

    .validation-success {
      border-bottom: 2px solid #5cb85c !important;
    }

    @media (max-width: 768px) {
      .header-title { font-size: 1.3rem; }
    }
    @media (max-width: 576px) {
      .header-title { font-size: 1.2rem; }
      .star { font-size: 35px; }
      .emoji-feedback { font-size: 22px; }
    }
  </style>
</head>
<body>
  <header class="custom-header">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid justify-content-between align-items-center">
        <a href="#" class="text-white me-auto" onclick="history.back()">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
          </svg>
        </a>
        <div class="dropdown ms-auto">
          <button class="btn dropdown-toggle lang-selector-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-globe" viewBox="0 0 16 16">
              <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm1.018 0h2.49c.04-1.333.201-2.572.454-3.637A6.97 6.97 0 0 0 1.018 8zm0 0a6.97 6.97 0 0 0 2.944 3.637c-.253-1.065-.414-2.304-.454-3.637zm6.982 6.982c-.63-.638-1.152-1.721-1.483-3.034A13.2 13.2 0 0 1 6.018 8c0-1.17.166-2.27.499-3.156.33-1.314.853-2.396 1.483-3.034A7 7 0 0 1 8 14.982zm1.483-6.982c0 1.17-.166 2.27-.499-3.156-.33 1.314-.853 2.396-1.483 3.034A7 7 0 0 0 8 14.982 7 7 0 0 0 8 1.018c.63.638 1.152 1.721 1.483 3.034.333.887.499 1.987.499 3.156zm1.509 3.637A6.97 6.97 0 0 0 14.982 8h-2.49c-.04 1.333-.201 2.572-.454 3.637zm2.49-4.637a6.97 6.97 0 0 0-2.944-3.637c.253 1.065.414 2.304.454 3.637h2.49z"/>
            </svg>
            <span id="current-lang-text">English</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" data-lang="en">English</a></li>
            <li><a class="dropdown-item" href="#" data-lang="tr">Türkçe</a></li>
            <li><a class="dropdown-item" href="#" data-lang="ku">كوردی</a></li>
            <li><a class="dropdown-item" href="#" data-lang="ar">العربية</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <h1 class="header-title" id="feedback-title">Feedback</h1>

  <form id="feedback-form">
    @csrf
    <div class="feedback-wrap">
      <div class="feedback-section">
        <div class="category-label" id="staff-label">Staff</div>
        <div class="stars">
          <button class="star" type="button" data-value="1">☆</button>
          <button class="star" type="button" data-value="2">☆</button>
          <button class="star" type="button" data-value="3">☆</button>
          <button class="star" type="button" data-value="4">☆</button>
          <button class="star" type="button" data-value="5">☆</button>
        </div>
        <div class="error-message" id="staff-error">Please rate our staff</div>
      </div>

      <div class="feedback-section">
        <div class="category-label" id="service-label">Service</div>
        <div class="stars">
          <button class="star" type="button" data-value="1">☆</button>
          <button class="star" type="button" data-value="2">☆</button>
          <button class="star" type="button" data-value="3">☆</button>
          <button class="star" type="button" data-value="4">☆</button>
          <button class="star" type="button" data-value="5">☆</button>
        </div>
        <div class="error-message" id="service-error">Please rate our service</div>
      </div>

      <div class="feedback-section">
        <div class="category-label" id="hygiene-label">Hygiene</div>
        <div class="stars">
          <button class="star" type="button" data-value="1">☆</button>
          <button class="star" type="button" data-value="2">☆</button>
          <button class="star" type="button" data-value="3">☆</button>
          <button class="star" type="button" data-value="4">☆</button>
          <button class="star" type="button" data-value="5">☆</button>
        </div>
        <div class="error-message" id="hygiene-error">Please rate hygiene</div>
      </div>

      <div class="feedback-section">
        <div class="category-label" id="overall-label">How was your overall experience?</div>
        <div class="emoji-group">
          <button type="button" class="emoji-feedback" data-value="very-poor">😵</button>
          <button type="button" class="emoji-feedback" data-value="poor">😟</button>
          <button type="button" class="emoji-feedback" data-value="neutral">🙂</button>
          <button type="button" class="emoji-feedback" data-value="good">😄</button>
          <button type="button" class="emoji-feedback" data-value="excellent">🤩</button>
        </div>
        <div class="error-message" id="overall-error">Please select your overall experience</div>
      </div>
    </div>

    <div class="contact-sections-wrap">
      <div class="contact-section">
        <div class="section-label" id="contact-label">Contact</div>
        <input type="tel" id="phone-placeholder" name="phone" placeholder="Phone number" />
        <div class="error-message" id="phone-error">Please enter a valid phone number</div>
      </div>

      <div class="contact-section">
        <div class="section-label" id="comment-label">Any additional comment:</div>
        <textarea id="comment-placeholder" name="comment" placeholder="Click here to make comment" rows="3"></textarea>
        <div class="error-message" id="comment-error">Comment cannot exceed 500 characters</div>
      </div>
    </div>

    <button class="btn-send" type="submit" id="send-btn">Send</button>
  </form>

  <div class="confirmation-message" id="confirmation-message">
    <h3 id="confirmation-title">Thank You!</h3>
    <p id="confirmation-text">Your feedback has been submitted successfully.</p>
    <button id="confirmation-button">OK</button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Form validation state
    let formIsValid = false;

    // Validation rules
    const validationRules = {
      staff: { required: true, minRating: 1 },
      service: { required: true, minRating: 1 },
      hygiene: { required: true, minRating: 1 },
      overall: { required: true },
      phone: { required: false, pattern: /^[\+]?[0-9\s\-\(\)]{8,15}$/ },
      comment: { required: false, maxLength: 500 }
    };

    // --- Star rating logic ---
    document.querySelectorAll('.stars').forEach(starContainer => {
      const stars = starContainer.querySelectorAll('.star');

      stars.forEach((star, index) => {
        star.addEventListener('mouseover', () => {
          stars.forEach((s, i) => {
            s.textContent = i <= index ? '★' : '☆';
            s.style.color = i <= index ? '#FFD700' : '#254034';
          });
        });

        star.addEventListener('mouseout', () => {
          stars.forEach((s) => {
            s.textContent = s.classList.contains('active') ? '★' : '☆';
            s.style.color = s.classList.contains('active') ? '#FFD700' : '#254034';
          });
        });

        star.addEventListener('click', () => {
          stars.forEach((s, i) => {
            s.classList.toggle('active', i <= index);
            s.textContent = i <= index ? '★' : '☆';
            s.style.color = i <= index ? '#FFD700' : '#254034';
          });

          // Validate after selection
          validateForm();
        });
      });
    });

    // --- Emoji selection logic ---
    document.querySelectorAll('.emoji-group').forEach(emojiContainer => {
      const emojis = emojiContainer.querySelectorAll('.emoji-feedback');

      emojis.forEach(emoji => {
        emoji.addEventListener('click', () => {
          emojis.forEach(e => e.classList.remove('selected'));
          emoji.classList.add('selected');

          // Validate after selection
          validateForm();
        });
      });
    });

    // --- Input validation ---
    document.getElementById('phone-placeholder').addEventListener('input', function() {
      validatePhone();
      validateForm();
    });

    document.getElementById('comment-placeholder').addEventListener('input', function() {
      validateComment();
      validateForm();
    });

    // Phone validation
    function validatePhone() {
      const phoneInput = document.getElementById('phone-placeholder');
      const phoneError = document.getElementById('phone-error');
      const phoneValue = phoneInput.value.trim();

      if (phoneValue === '') {
        // Phone is optional, so no error if empty
        phoneInput.classList.remove('validation-error', 'validation-success');
        phoneError.style.display = 'none';
        return true;
      }

      if (validationRules.phone.pattern.test(phoneValue)) {
        phoneInput.classList.remove('validation-error');
        phoneInput.classList.add('validation-success');
        phoneError.style.display = 'none';
        return true;
      } else {
        phoneInput.classList.remove('validation-success');
        phoneInput.classList.add('validation-error');
        phoneError.style.display = 'block';
        return false;
      }
    }

    // Comment validation
    function validateComment() {
      const commentInput = document.getElementById('comment-placeholder');
      const commentError = document.getElementById('comment-error');
      const commentValue = commentInput.value.trim();

      if (commentValue.length <= validationRules.comment.maxLength) {
        commentInput.classList.remove('validation-error');
        commentInput.classList.add('validation-success');
        commentError.style.display = 'none';
        return true;
      } else {
        commentInput.classList.remove('validation-success');
        commentInput.classList.add('validation-error');
        commentError.style.display = 'block';
        return false;
      }
    }

    // Star rating validation
    function validateStars() {
      let allValid = true;

      // Staff rating
      const staffRating = document.querySelectorAll('.feedback-section:nth-child(1) .star.active').length;
      const staffError = document.getElementById('staff-error');
      if (validationRules.staff.required && staffRating < validationRules.staff.minRating) {
        staffError.style.display = 'block';
        allValid = false;
      } else {
        staffError.style.display = 'none';
      }

      // Service rating
      const serviceRating = document.querySelectorAll('.feedback-section:nth-child(2) .star.active').length;
      const serviceError = document.getElementById('service-error');
      if (validationRules.service.required && serviceRating < validationRules.service.minRating) {
        serviceError.style.display = 'block';
        allValid = false;
      } else {
        serviceError.style.display = 'none';
      }

      // Hygiene rating
      const hygieneRating = document.querySelectorAll('.feedback-section:nth-child(3) .star.active').length;
      const hygieneError = document.getElementById('hygiene-error');
      if (validationRules.hygiene.required && hygieneRating < validationRules.hygiene.minRating) {
        hygieneError.style.display = 'block';
        allValid = false;
      } else {
        hygieneError.style.display = 'none';
      }

      return allValid;
    }

    // Overall experience validation
    function validateOverall() {
      const overallSelected = document.querySelector('.emoji-feedback.selected');
      const overallError = document.getElementById('overall-error');

      if (validationRules.overall.required && !overallSelected) {
        overallError.style.display = 'block';
        return false;
      } else {
        overallError.style.display = 'none';
        return true;
      }
    }

    // Complete form validation
    function validateForm() {
      const starsValid = validateStars();
      const overallValid = validateOverall();
      const phoneValid = validatePhone();
      const commentValid = validateComment();

      formIsValid = starsValid && overallValid && phoneValid && commentValid;

      // Update send button state
      const sendBtn = document.getElementById('send-btn');
      if (formIsValid) {
        sendBtn.disabled = false;
      } else {
        sendBtn.disabled = true;
      }

      return formIsValid;
    }

    // --- Form submission ---
    document.getElementById('feedback-form').addEventListener('submit', async (e) => {
      e.preventDefault();

      // Final validation before submission
      if (!validateForm()) {
        // Scroll to first error
        const firstError = document.querySelector('.error-message[style*="display: block"]');
        if (firstError) {
          firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
      }

      // Collect all feedback data
      const staffRating = document.querySelectorAll('.feedback-section:nth-child(1) .star.active').length;
      const serviceRating = document.querySelectorAll('.feedback-section:nth-child(2) .star.active').length;
      const hygieneRating = document.querySelectorAll('.feedback-section:nth-child(3) .star.active').length;
      const overallExperience = document.querySelector('.emoji-feedback.selected')?.getAttribute('data-value') || '';
      const phone = document.getElementById('phone-placeholder').value.trim();
      const comment = document.getElementById('comment-placeholder').value.trim();

      try {
        const response = await fetch('/feedback/submit', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            staff_rating: staffRating || null,
            service_rating: serviceRating || null,
            hygiene_rating: hygieneRating || null,
            overall_experience: overallExperience || null,
            phone: phone || null,
            comment: comment || null
          })
        });

        const result = await response.json();

        if (result.success) {
          showConfirmation();
        } else {
          alert('Failed to submit feedback. Please try again.');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Failed to submit feedback. Please try again.');
      }
    });

    // --- Confirmation message ---
    function showConfirmation() {
      const confirmationMessage = document.getElementById('confirmation-message');
      confirmationMessage.style.display = 'block';

      // Reset form after confirmation
      document.getElementById('confirmation-button').addEventListener('click', () => {
        confirmationMessage.style.display = 'none';
        resetForm();
      });
    }

    // Reset form function
    function resetForm() {
      document.getElementById('feedback-form').reset();

      // Reset stars
      document.querySelectorAll('.star').forEach(star => {
        star.classList.remove('active');
        star.textContent = '☆';
        star.style.color = '#254034';
      });

      // Reset emojis
      document.querySelectorAll('.emoji-feedback').forEach(emoji => {
        emoji.classList.remove('selected');
      });

      // Reset validation states
      document.querySelectorAll('.validation-error, .validation-success').forEach(el => {
        el.classList.remove('validation-error', 'validation-success');
      });

      document.querySelectorAll('.error-message').forEach(el => {
        el.style.display = 'none';
      });

      // Reset form validation state
      formIsValid = false;
      document.getElementById('send-btn').disabled = true;
    }

    // --- Language translations ---
    const translations = {
      en: {
        feedback: 'Feedback',
        staff: 'Staff',
        service: 'Service',
        hygiene: 'Hygiene',
        overall: 'How was your overall experience?',
        contact: 'Contact',
        phone: 'Phone number',
        comment: 'Any additional comment:',
        commentPlaceholder: 'Click here to make comment',
        send: 'Send',
        langText: 'English',
        thankYou: 'Thank You!',
        confirmation: 'Your feedback has been submitted successfully.',
        ok: 'OK',
        staffError: 'Please rate our staff',
        serviceError: 'Please rate our service',
        hygieneError: 'Please rate hygiene',
        overallError: 'Please select your overall experience',
        phoneError: 'Please enter a valid phone number',
        commentError: 'Comment cannot exceed 500 characters'
      },
      tr: {
        feedback: 'Geri Bildirim',
        staff: 'Personel',
        service: 'Hizmet',
        hygiene: 'Hijyen',
        overall: 'Genel deneyiminiz nasıldı?',
        contact: 'İletişim',
        phone: 'Telefon numarası',
        comment: 'Ekstra yorumlar:',
        commentPlaceholder: 'Yorum yapmak için tıklayın',
        send: 'Gönder',
        langText: 'Türkçe',
        thankYou: 'Teşekkürler!',
        confirmation: 'Geri bildiriminiz başarıyla gönderildi.',
        ok: 'Tamam',
        staffError: 'Lütfen personelimizi değerlendirin',
        serviceError: 'Lütfen hizmetimizi değerlendirin',
        hygieneError: 'Lütfen hijyeni değerlendirin',
        overallError: 'Lütfen genel deneyiminizi seçin',
        phoneError: 'Lütfen geçerli bir telefon numarası girin',
        commentError: 'Yorum 500 karakteri geçemez'
      },
      ku: {
        feedback: 'بازخۆ',
        staff: 'کارمەند',
        service: 'خزمەت',
        hygiene: 'پاکیزەیی',
        overall: 'تجربەی گشتی چۆن بوو؟',
        contact: 'پەیوەندیدان',
        phone: 'ژمارەی تەلەفۆن',
        comment: 'هەر تێبینیەکی زیادە:',
        commentPlaceholder: 'کلیک بکە بۆ نووسینی تێبینی',
        send: 'ناردن',
        langText: 'كوردی',
        thankYou: 'سوپاس!',
        confirmation: 'بازخۆکەت بە سەرکەوتوویی نێردرا.',
        ok: 'باشە',
        staffError: 'تکایە کارمەندەکانمان هەڵبسەنگێنە',
        serviceError: 'تکایە خزمەتگوزاریەکەمان هەڵبسەنگێنە',
        hygieneError: 'تکایە پاکیزەیی هەڵبسەنگێنە',
        overallError: 'تکایە تجربەی گشتی هەڵبژێرە',
        phoneError: 'تکایە ژمارەی تەلەفۆنێکی دروست بنووسە',
        commentError: 'تێبینی نابێت زیاتر لە ٥٠٠ پیت بێت'
      },
      ar: {
        feedback: 'ملاحظات',
        staff: 'الموظفين',
        service: 'الخدمة',
        hygiene: 'النظافة',
        overall: 'كيف كانت تجربتك بشكل عام؟',
        contact: 'تواصل',
        phone: 'رقم الهاتف',
        comment: 'أي تعليق إضافي:',
        commentPlaceholder: 'انقر هنا لإضافة تعليق',
        send: 'إرسال',
        langText: 'العربية',
        thankYou: 'شكراً لك!',
        confirmation: 'تم إرسال ملاحظاتك بنجاح.',
        ok: 'موافق',
        staffError: 'يرجى تقييم موظفينا',
        serviceError: 'يرجى تقييم خدمتنا',
        hygieneError: 'يرجى تقييم النظافة',
        overallError: 'يرجى اختيار تجربتك العامة',
        phoneError: 'يرجى إدخال رقم هاتف صحيح',
        commentError: 'لا يمكن أن يتجاوز التعليق 500 حرف'
      }
    };

    function applyLanguage(lang) {
      document.getElementById('feedback-title').textContent = translations[lang].feedback;
      document.getElementById('staff-label').textContent = translations[lang].staff;
      document.getElementById('service-label').textContent = translations[lang].service;
      document.getElementById('hygiene-label').textContent = translations[lang].hygiene;
      document.getElementById('overall-label').textContent = translations[lang].overall;
      document.getElementById('contact-label').textContent = translations[lang].contact;
      document.getElementById('phone-placeholder').placeholder = translations[lang].phone;
      document.getElementById('comment-label').textContent = translations[lang].comment;
      document.getElementById('comment-placeholder').placeholder = translations[lang].commentPlaceholder;
      document.getElementById('send-btn').textContent = translations[lang].send;
      document.getElementById('current-lang-text').textContent = translations[lang].langText;
      document.getElementById('confirmation-title').textContent = translations[lang].thankYou;
      document.getElementById('confirmation-text').textContent = translations[lang].confirmation;
      document.getElementById('confirmation-button').textContent = translations[lang].ok;

      // Update error messages
      document.getElementById('staff-error').textContent = translations[lang].staffError;
      document.getElementById('service-error').textContent = translations[lang].serviceError;
      document.getElementById('hygiene-error').textContent = translations[lang].hygieneError;
      document.getElementById('overall-error').textContent = translations[lang].overallError;
      document.getElementById('phone-error').textContent = translations[lang].phoneError;
      document.getElementById('comment-error').textContent = translations[lang].commentError;
    }

    // --- Language selection ---
    const savedLang = localStorage.getItem('pageLanguage') || 'en';
    applyLanguage(savedLang);

    document.querySelectorAll('.dropdown-item').forEach(item => {
      item.addEventListener('click', e => {
        e.preventDefault();
        const lang = item.getAttribute('data-lang');
        localStorage.setItem('pageLanguage', lang);
        applyLanguage(lang);
      });
    });

    // Initialize form validation on page load
    document.addEventListener('DOMContentLoaded', function() {
      validateForm();
    });
  </script>
</body>
</html>
