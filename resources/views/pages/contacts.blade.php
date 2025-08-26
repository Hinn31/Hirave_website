<header>
  <link rel="stylesheet" href="{{ asset('css/contacts.css') }}">
</header>
@extends('layouts.master')

@section('title', 'Contact')

@section('content')
<div class="container">
  <div class="contact-info">
    <h2>Contact Information</h2>
    <p class="subtitle">Say something to start a live chat!</p>

    <div class="contact-item">
      <!-- Phone icon SVG -->
      <svg viewBox="0 0 24 24"><path d="M6.62 10.79a15.091 15.091 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21c1.21.48 2.53.75 3.88.75a1 1 0 011 1v3.5a1 1 0 01-1 1C10.07 21 3 13.93 3 5a1 1 0 011-1h3.5a1 1 0 011 1c0 1.35.26 2.67.75 3.88a1 1 0 01-.21 1.11l-2.42 2.42z"/></svg>
      0876 068 001
    </div>

    <div class="contact-item">
      <!-- Email icon SVG -->
      <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-2 .89-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6c0-1.11-.89-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
      vohien1315@gmail.com
    </div>

    <div class="contact-item" style="max-width: 260px;">
      <!-- Location icon SVG -->
      <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
      132 Dartmouth Street Boston, <br />
      Massachusetts 02156 United States
    </div>

  </div>

  <form id="contactForm" class="contact-form">
      @csrf
      <div class="form-row" style="gap: 30px;">
        <div class="form-row half">
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" name="first_name" required />
        </div>
        <div class="form-row half">
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="last_name" required />
        </div>
      </div>

      <div class="form-row" style="gap: 30px;">
        <div class="form-row half">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="form-row half">
          <label for="phoneNumber">Phone Number</label>
          <input type="text" id="phoneNumber" name="phone_number" />
        </div>
      </div>

      <div class="form-row_message">
        <textarea id="message" name="message" placeholder="Write your message.." required></textarea>
      </div>

      <button type="submit" class="send-button">Send Message</button>
  </form>

  <div id="responseMessage"></div>

 <script>
document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    let res = await fetch("{{ route('contact.send') }}", {
        method: "POST",
        headers: {
            "Accept": "application/json"
        },
        body: formData
    });

    let data = await res.json();

   if(data.success) {
        // Chuyển sang component success
        window.location.href = "{{ route('component.success_one') }}";
    } else {
        alert(data.message || "Something went wrong!");
    }
    }); // ← Đóng ngoặc và dấu chấm phẩy

</script>

</div>
@endsection
