import { extend } from "vee-validate"
import { required, max, min } from "vee-validate/dist/rules.umd.js";

extend("max", max);
extend("min", min);
extend("required", required);

const email = {
    validate(value) {
        return value.match(/^\w+([\\.-]?\w+)*@\w+([\\.-]?\w+)*(\.\w{2,6})+$/);
    },
    params: ["text"],
    message: "{text}",
};
const emailMuti = {
    validate(value) {
        const email = value.split(";");
        let check = '';
        for (var i = 0; i < email.length; i++) {
            check = email[i].match(/^\w+([\\.-]?\w+)*@\w+([\\.-]?\w+)*(\.\w{2,6})+$/);
        }
        return check;
    },
    params: ["text"],
    message: "{text}",
};

const password = {
    validate(value) {
        return typeof value === "string" && value.length >= 8;
    },
    params: ["text"],
    message: "{text}"
};
const postcode = {
    validate(value) {
        return value.match(/^\d{3}-?\d{4}$/g);
    },
    message: "Vui lòng nhập mã zip chính xác!",
};
const errDateStart = {
    validate(value, { date }) {
        return value <= date
    },
    params: ["date", "textOne", "text", "textTwo"],
    message: "{textOne} {text} {textTwo}!",
}


const errDateEnd = {
    validate(value, { date }) {
        return value >= date
    },
    params: ["date", "textOne", "text",  "textTwo"],
    message: "{textOne} {text} {textTwo}!",
}

extend("required", {
    ...required,
    params: ["text"],
    message: "{text}"
});

const integerOnly = {
    validate(value) {
        return value.match(/^[0-9]*$/);
    },
    params: ["text"],
    message: "{text}"
}

const errDateZeroZeroFive = {
    validate(value, { now }) {
      return value >= now
    },
    params: ["now", "textOne", "text"],
    message: "{textOne} {text}",
}

const errTime = {
    validate(value, {time }) {
      if (value < time) {
        return value > time;
      }
      return value >= time;
    },
    params: ["time", "textOne", "text"],
    message: "{textOne} {text}",
}

const phone = {
    validate(value) {
        return typeof value == "string" && value.length < 11 && value.length >= 10;
    },
    params: ["text"],
    message: "{text}"
};
const citizenIdentity = {
    validate(value) {
        return typeof value == "string" && value.length < 13;
    },
    params: ["text"],
    message: "{text}"
};
const minNumber = {
    validate(value) {
        return typeof value == "string" && value.length < 0;
    },
    params: ["text"],
    message: "{text}"
};
const maxNumber = {
    validate(value) {
        return typeof value == "string" && value.length >= 50 ;
    },
    params: ["text"],
    message: "{text}"
};

extend('err-start-date', errDateStart);
extend('err-end-date', errDateEnd);
extend('email', email);
extend('integer-only', integerOnly);
extend('password', password );
extend('err-start-date', errDateStart);
extend('err-end-date', errDateEnd);
extend('err-past-day', errDateZeroZeroFive);
extend('err-time', errTime);
extend('phone', phone);
extend('citizen-identity', citizenIdentity);
extend('min-number', minNumber);
extend('max-number', maxNumber);
extend('email-muti', emailMuti);
export {
    errDateStart,
    errDateEnd,
    postcode,
    password,
    email,
    integerOnly,
    errDateZeroZeroFive,
    errTime,
    phone,
    citizenIdentity,
    minNumber,
    maxNumber,
    emailMuti
}