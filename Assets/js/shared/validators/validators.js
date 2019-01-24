const length = (minLength, maxLength, entity) => (value) => {
  if (value.length < minLength || value.length > maxLength) {
    return `${entity} must be between ${minLength} and ${maxLength} characters long.`;
  }

  return null;
};

const required = (entity) => (value) => {
  if(value.length === 0) {
    return `${entity} is required.`;
  }

  return null;
};

const mustMatch = (otherField, entity) => (value, fieldValues) => {
  const otherValue = fieldValues[otherField];

  if (value !== otherValue) {
    return `${entity} must match.`;
  }

  return null;
};
