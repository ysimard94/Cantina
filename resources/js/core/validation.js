// validation.js
import { rules } from "@/config/constants";

const validate = (key, value) => {
    const fieldRules = rules[key];

    if (!fieldRules) {
        return true;
    }
    const validationResult = fieldRules.every((rule) => rule.$validator(value));
    return validationResult;
};

export { validate };
