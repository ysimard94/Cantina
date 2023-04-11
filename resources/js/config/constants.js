import { required, minLength, email } from "@vuelidate/validators";
const rules = {
    email: [required, email],
    password: [required, minLength(8)],
    username: [required, minLength(3)],
    img_url: [required, minLength(5)],
    price: [required],
    name: [required, minLength(5)],
    description: [required, minLength(5)],
    category_id: [required],
    // Add more rules for other fields as needed
};

export { rules };
