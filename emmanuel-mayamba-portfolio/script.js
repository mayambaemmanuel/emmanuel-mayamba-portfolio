"use strict";

// Keep the mobile navigation accessible to keyboard and screen-reader users.
const menuToggle = document.querySelector(".menu-toggle");
const navigationLinks = document.querySelector(".nav-links");
const mobileViewport = window.matchMedia("(max-width: 560px)");
menuToggle.hidden = false;
document.documentElement.classList.add("js-enabled");

function setMenuOpen(isOpen) {
  menuToggle.setAttribute("aria-expanded", String(isOpen));
  menuToggle.querySelector(".menu-label").textContent = isOpen ? "Close" : "Menu";
  navigationLinks.classList.toggle("is-open", isOpen);
}

menuToggle.addEventListener("click", () => {
  setMenuOpen(menuToggle.getAttribute("aria-expanded") !== "true");
});
navigationLinks.addEventListener("click", (event) => {
  if (event.target.closest("a")) setMenuOpen(false);
});
document.addEventListener("keydown", (event) => {
  if (event.key === "Escape" && menuToggle.getAttribute("aria-expanded") === "true") {
    setMenuOpen(false);
    menuToggle.focus();
  }
});
document.addEventListener("click", (event) => {
  if (!event.target.closest(".navigation")) setMenuOpen(false);
});
mobileViewport.addEventListener("change", () => setMenuOpen(false));

// Cycle through an array to generate content without reloading the page.
const learningTopics = JSON.parse(document.querySelector("#learning-topics").textContent);
let focusIndex = 0;
const focusContent = document.querySelector("#focus-content");
function renderFocus() {
  focusContent.textContent = learningTopics[focusIndex];
}
renderFocus();
document.querySelector(".learning-focus").hidden = false;
document.querySelector("#next-focus").addEventListener("click", () => {
  focusIndex = (focusIndex + 1) % learningTopics.length;
  renderFocus();
});
document.querySelector("#current-year").textContent = new Date().getFullYear();

// Validate in the browser, then send to PHP for validation and MySQL storage.
const contactForm = document.querySelector("#contact-form");
const formStatus = document.querySelector("#form-status");
const fields = Array.from(contactForm.querySelectorAll("input:not([type=hidden]), textarea"));
contactForm.hidden = false;
contactForm.noValidate = true;

function validateField(field) {
  let error = "";
  if (!field.value.trim()) {
    error = field.name === "name" ? "Please enter your name." :
      field.name === "email" ? "Please enter your email address." : "Please enter a message.";
  } else if (field.name === "email" &&
    (field.validity.typeMismatch || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value))) {
    error = "Please enter a valid email address, such as name@example.com.";
  }
  document.getElementById(`${field.name}-error`).textContent = error;
  field.setAttribute("aria-invalid", String(Boolean(error)));
  return error === "";
}

fields.forEach((field) => {
  field.addEventListener("input", () => {
    formStatus.textContent = "";
    if (field.hasAttribute("aria-invalid")) validateField(field);
  });
});
contactForm.addEventListener("submit", async (event) => {
  event.preventDefault();
  const invalidFields = fields.filter((field) => !validateField(field));
  if (invalidFields.length > 0) {
    formStatus.textContent = "Please correct the highlighted fields.";
    invalidFields[0].focus();
  } else {
    const submitButton = contactForm.querySelector("button[type=submit]");
    submitButton.disabled = true;
    formStatus.textContent = "Saving your message…";
    try {
      const response = await fetch(contactForm.action, {
        method: "POST",
        body: new FormData(contactForm)
      });
      const result = await response.json();
      formStatus.textContent = result.message;
      if (response.ok) {
        contactForm.reset();
        fields.forEach((field) => field.removeAttribute("aria-invalid"));
      }
    } catch (error) {
      formStatus.textContent = "Could not save your message. Check your connection and try again.";
    } finally {
      submitButton.disabled = false;
    }
  }
});
