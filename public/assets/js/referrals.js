document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".g360-form");
  if (!form) return;

  // Validation rules
  const validationRules = {
    first_name: {
      required: true,
      minLength: 2,
      maxLength: 50,
    },
    last_name: {
      required: true,
      minLength: 2,
      maxLength: 50,
    },
    email: {
      required: true,
      pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    },
    phone: {
      required: true,
      pattern: /^\+?[\d\s-]{10,}$/,
    },
    company_name: {
      required: true,
      minLength: 2,
      maxLength: 100,
    },
    country: {
      required: true,
    },
    gdpr: {
      required: true,
    },
  };

  // Error messages
  const errorMessages = {
    required: "This field is required",
    minLength: "Must be at least {min} characters",
    maxLength: "Must be no more than {max} characters",
    pattern: "Please enter a valid value",
    email: "Please enter a valid email address",
    phone: "Please enter a valid phone number",
  };

  // Show error message
  function showError(input, message) {
    const formGroup = input.closest(".g360-form-group");
    const errorDiv = formGroup.querySelector(".g360-form-error") || document.createElement("div");
    errorDiv.className = "g360-form-error";
    errorDiv.textContent = message;

    if (!formGroup.querySelector(".g360-form-error")) {
      formGroup.appendChild(errorDiv);
    }

    input.classList.add("g360-input-error");
  }

  // Clear error message
  function clearError(input) {
    const formGroup = input.closest(".g360-form-group");
    const errorDiv = formGroup.querySelector(".g360-form-error");
    if (errorDiv) {
      errorDiv.remove();
    }
    input.classList.remove("g360-input-error");
  }

  // Validate single field
  function validateField(input) {
    const rules = validationRules[input.name];
    if (!rules) return true;

    clearError(input);
    let isValid = true;

    if (rules.required && !input.value.trim()) {
      showError(input, errorMessages.required);
      isValid = false;
    }

    if (isValid && rules.minLength && input.value.length < rules.minLength) {
      showError(input, errorMessages.minLength.replace("{min}", rules.minLength));
      isValid = false;
    }

    if (isValid && rules.maxLength && input.value.length > rules.maxLength) {
      showError(input, errorMessages.maxLength.replace("{max}", rules.maxLength));
      isValid = false;
    }

    if (isValid && rules.pattern && !rules.pattern.test(input.value)) {
      showError(input, errorMessages[input.type] || errorMessages.pattern);
      isValid = false;
    }

    return isValid;
  }

  // Validate all fields
  function validateForm() {
    let isValid = true;
    const inputs = form.querySelectorAll("input, select");

    inputs.forEach((input) => {
      if (!validateField(input)) {
        isValid = false;
      }
    });

    return isValid;
  }

  // Handle form submission
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (!validateForm()) {
      return;
    }

    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = "Submitting...";

    try {
      const formData = new FormData(form);
      const response = await fetch("/submit", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        // Show success message
        const successMessage = document.createElement("div");
        successMessage.className = "g360-form-success";
        successMessage.textContent = "Thank you! Your referral has been submitted successfully.";
        form.innerHTML = "";
        form.appendChild(successMessage);
      } else {
        throw new Error(result.error || "Something went wrong");
      }
    } catch (error) {
      const errorMessage = document.createElement("div");
      errorMessage.className = "g360-form-error";
      errorMessage.textContent = error.message;
      form.insertBefore(errorMessage, form.firstChild);
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = "Submit";
    }
  });

  // Real-time validation
  form.querySelectorAll("input, select").forEach((input) => {
    input.addEventListener("blur", () => validateField(input));
    input.addEventListener("input", () => {
      if (input.classList.contains("g360-input-error")) {
        validateField(input);
      }
    });
  });
});
