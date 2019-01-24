class FormValidator {
  constructor(validationOptions) {
    this.__validationOptions = validationOptions;
  }

  initialize() {
    this.__setDOMElements();
    this.__initializeFormState();
    this.__initializeFieldErrors();

    this.__initializeFieldEvents();
    this.__initializeFormEvents();
  }

  __setDOMElements() {
    this.__form = document.getElementById(this.__validationOptions.formId);
    this.__formFields = [...this.__form.elements].filter(el => el.type !== 'submit');
    this.__formSubmitButton = [...this.__form.elements].find(el => el.type === 'submit');
  }

  __initializeFormState() {
    this.__formState = 'pristine';

    this.__fieldStates = this.__getFieldNames().reduce((accumulatedState, fieldName) => ({
      ...accumulatedState,
      [fieldName]: 'pristine'
    }), {});
  }

  __initializeFieldErrors() {
    const fieldNames = this.__getFieldNames();

    this.__fieldErrors = fieldNames.reduce((accumulatedErrors, currentField) => ({
        ...accumulatedErrors,
        [currentField]: this.__getValidationError(currentField)
      }),
      {}
    );
  }

  __initializeFieldEvents() {
    this.__formFields.forEach(field => {
      field.addEventListener('change', () => this.__onFieldValueChange(field));
      field.addEventListener('keyup', () => this.__onFieldKeyUp());
      field.addEventListener('blur', () => this.__onFieldBlur(field));
    });
  }

  __initializeFormEvents() {
    this.__form.addEventListener("submit", (event) => {
      this.__formState = 'dirty';
      this.__validateFields();

      if (!this.__isFormValid()) {
        event.preventDefault();
      }
    });
  }

  __onFieldValueChange(field) {
    this.__fieldStates[field.name] = 'dirty';

    this.__validateFields();
  }

  __onFieldKeyUp() {
    this.__validateFields();
  }

  __onFieldBlur(field) {
    if (this.__fieldStates[field.name] === 'pristine') {
      this.__fieldStates[field.name] = 'touched';
    }

    this.__validateFields();
  }

  __validateFields() {
    this.__formFields.forEach(field => this.__validateField(field));
  }

  __validateField(field) {
    const validationError = this.__getValidationError(field.name);
    this.__fieldErrors[field.name] = validationError;

    const fieldState = this.__fieldStates[field.name];
    const shouldShowError = validationError && (this.__formState === 'dirty' || fieldState === 'dirty' || fieldState === 'touched');

    if (shouldShowError) {
      this.__showError(field, validationError);
    } else {
      this.__hideError(field);
    }
  }

  __showError(field, validationError) {
    field.classList.add('error');

    const errorSpanId = `${field.name}-error`;
    let errorSpan = document.getElementById(errorSpanId);

    if (!errorSpan) {
      errorSpan = document.createElement("span");
      errorSpan.id = `${field.name}-error`;
      errorSpan.className = "field-error-message";
      insertAfter(field, errorSpan);
    }

    errorSpan.textContent = validationError;
  }

  __hideError(field) {
    field.classList.remove('error');

    const errorSpanId = `${field.name}-error`;
    const errorSpan = document.getElementById(errorSpanId);

    if (errorSpan) {
      errorSpan.remove();
    }
  }

  __getFieldNames() {
    return this.__formFields.map(f => f.name);
  }

  __getValidationError(fieldName) {
    let fieldError = null;

    const fieldValidators = this.__validationOptions.validations[fieldName];

    if (fieldValidators) {
      const fieldValues = this.__getFieldValues();

      for (const validator of fieldValidators) {
        const error = validator(fieldValues[fieldName], fieldValues);

        if (error !== null) {
          fieldError = error;
          break;
        }
      }
    }

    return fieldError;
  }

  __getFieldValues() {
    return this.__formFields.reduce((accumulatedValues, currentField) => ({
      ...accumulatedValues,
      [currentField.name]: currentField.value
    }), {});
  }

  __isFormValid() {
    return Object.keys(this.__fieldErrors).every(fieldName => this.__fieldErrors[fieldName] === null);
  }
}

function insertAfter(referenceNode, newNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}
