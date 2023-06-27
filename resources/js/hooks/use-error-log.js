/*js Error Log Collection */
import { jsErrorCollection } from "js-error-collection";
import pack from "../../../package.json";
import settings from "@/settings";
import bus from "@/utils/bus";
import axiosReq from "axios";
const reqUrl = "/integration-front/errorCollection/insert";
const errorLogReq = (errLog) => {
    axiosReq({
        url: reqUrl,
        data: {
            pageUrl: window.location.href,
            errorLog: errLog,
            browserType: navigator.userAgent,
            version: pack.version,
        },
        method: "post",
    }).then(() => {
        //Return Error Messages
        bus.emit("reloadErrorPage", {});
    });
};

export const useErrorLog = () => {
    //Check whether need to collect the error or not,由settings配置决定
    if (settings.errorLog?.includes(import.meta.env.VITE_APP_ENV)) {
        jsErrorCollection(
            { runtimeError: true, rejectError: true, consoleError: true },
            (errLog) => {
                //判断是否是reqUrl错误，避免死循环
                if (!errLog.includes(reqUrl)) errorLogReq(errLog);
            }
        );
    }
};
