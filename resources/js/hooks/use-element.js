import { reactive, ref, toRefs } from "vue";
import {
    ElLoading,
    ElMessage,
    ElMessageBox,
    ElNotification,
} from "element-plus";
export const useElement = () => {
    // positive value
    const upZeroInt = (rule, value, callback, msg) => {
        if (!value) {
            callback(new Error(`${msg} is required`));
        }
        if (/^\+?[1-9]\d*$/.test(value)) {
            callback();
        } else {
            callback(new Error(`${msg} input wrong format`));
        }
    };

    // positive value（include 0）
    const zeroInt = (rule, value, callback, msg) => {
        if (!value) {
            callback(new Error(`${msg} is required`));
        }
        if (/^\+?[0-9]\d*$/.test(value)) {
            callback();
        } else {
            callback(new Error(`${msg} input wrong format`));
        }
    };

    // currency
    const money = (rule, value, callback, msg) => {
        if (!value) {
            callback(new Error(`${msg} is required`));
        }
        if (/((^[1-9]\d*)|^0)(\.\d{0,2}){0,1}$/.test(value)) {
            callback();
        } else {
            callback(new Error(`${msg} input wrong format`));
        }
    };

    // phone
    const phone = (rule, value, callback, msg) => {
        if (!value) {
            callback(new Error(`${msg} is required`));
        }
        if (/^0?1[0-9]{10}$/.test(value)) {
            callback();
        } else {
            callback(new Error(`${msg} input wrong format`));
        }
    };

    // email
    const email = (rule, value, callback, msg) => {
        if (!value) {
            callback(new Error(`${msg} is required`));
        }
        if (
            /(^([a-zA-Z]|[0-9])(\w|-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4}))$/.test(
                value
            )
        ) {
            callback();
        } else {
            callback(new Error(`${msg}`));
        }
    };
    const state = reactive({
        /* table*/
        tableData: [],
        rowDeleteIdArr: [],
        loadingId: null,
        /* form*/
        formModel: {},
        subForm: {},
        searchForm: {},
        /* form rules*/
        formRules: {
            //is null
            isNull: (msg) => [
                { required: false, message: `${msg}`, trigger: "blur" },
            ],
            isNotNull: (msg) => [
                { required: true, message: `${msg}`, trigger: "blur" },
            ],
            // positive value
            upZeroInt: (msg) => [
                {
                    required: true,
                    validator: (rule, value, callback) =>
                        upZeroInt(rule, value, callback, msg),
                    trigger: "blur",
                },
            ],
            // positive value（include 0）
            zeroInt: (msg) => [
                {
                    required: true,
                    validator: (rule, value, callback) =>
                        zeroInt(rule, value, callback, msg),
                    trigger: "blur",
                },
            ],
            // currency
            money: (msg) => [
                {
                    required: true,
                    validator: (rule, value, callback) =>
                        money(rule, value, callback, msg),
                    trigger: "blur",
                },
            ],
            // phone
            phone: (msg) => [
                {
                    required: true,
                    validator: (rule, value, callback) =>
                        phone(rule, value, callback, msg),
                    trigger: "blur",
                },
            ],
            // email
            email: (msg) => [
                {
                    required: true,
                    validator: (rule, value, callback) =>
                        email(rule, value, callback, msg),
                    trigger: "blur",
                },
            ],
        },
        /* datepicker */
        datePickerOptions: {
            disabledDate: (time) => {
                return time.getTime() < Date.now() - 86400000;
            },
        },
        startEndArr: [],
        /* dialog*/
        dialogTitle: "Add",
        detailDialog: false,
        isDialogEdit: false,
        dialogVisible: false,
        tableLoading: false,
        treeData: [],
        defaultProps: {
            children: "children",
            label: "label",
        },
    });
    return {
        ...toRefs(state),
    };
};

/*
 * Notification
 * message
 * type
 * duration（ms）
 * */
export const elMessage = (message, type) => {
    ElMessage({
        showClose: true,
        message: message || "Success",
        type: type || "success",
        center: false,
    });
};
/*
 * loading
 * after loading put loadingId.close() to unset it
 * */
let loadingId = null;
export const elLoading = (msg) => {
    loadingId = ElLoading.service({
        lock: true,
        text: msg || "processing",
        // spinner: 'el-icon-loading',
        background: "rgba(0, 0, 0, 0.1)",
    });
};
export const closeElLoading = () => {
    loadingId.close();
};
/*
 * 提示
 * message: 提示内容
 * type：提示类型
 * title：提示标题
 * duration：提示时长（ms）
 * */
export const elNotify = (message, type, title, duration) => {
    ElNotification({
        title: title || "Info",
        type: type || "success",
        message: message || "Please insert your message",
        position: "top-right",
        duration: duration || 2500,
        offset: 40,
    });
};
/*
  确认弹框(没有取消按钮)
* title:提示的标题
* message:提示的内容
* return Promise
* */
export const elConfirmNoCancelBtn = (title, message) => {
    return ElMessageBox({
        message: message || "Are you sure to delete?",
        title: title || "Confirm Dialog",
        confirmButtonText: "Confirm",
        cancelButtonText: "Cancel",
        showCancelButton: false,
        type: "warning",
    });
};
/*
 * 确认弹框
 * title:提示的标题
 * message:提示的内容
 * return Promise
 * */
export const elConfirm = (title, message) => {
    return ElMessageBox({
        message: message || "Are you sure to delete?",
        title: title || "Confirm Dialog",
        confirmButtonText: "Confirm",
        cancelButtonText: "Cancel",
        type: "warning",
    });
};

/* 级联*/
const cascaderKey = ref();
export const casHandleChange = () => {
    // 解决目前级联选择器搜索输入报错问题
    cascaderKey.value += cascaderKey.value;
};
