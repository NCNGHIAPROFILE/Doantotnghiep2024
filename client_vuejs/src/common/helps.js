import { TOAST_TYPE } from "./constant.js";
import moment from "moment";

const toastOptionDefault = {
    position: 'top-center',
    timeout: 3000,
    closeOnClick: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: true,
    closeButton: "button",
    icon: true
}
/**
 * Display Toast
 * @param {*} context context
 * @param {*} message message content in toast
 * @param {*} type info | success | error | warning
 * @param {*} option configuration toast
 */
export const showToast = (context, message, type = TOAST_TYPE.INFO, option = toastOptionDefault) => {
    context.$toast[type](message, option);
}
export const convertDateTime = (value, format = "YYYY/MM/DD") => {
    return moment(String(value)).locale('vi').format(format);
}