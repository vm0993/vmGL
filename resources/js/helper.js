import dayjs from "dayjs";

const helpers = {
    cutText(text, length) {
        if (text.split(" ").length > 1) {
            let string = text.substring(0, length);
            let splitText = string.split(" ");
            splitText.pop();
            return splitText.join(" ") + "...";
        } else {
            return text;
        }
    },
    formatDate(date, format) {
        return dayjs(date).format(format);
    },
    capitalizeFirstLetter(string) {
        if (string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    },
    onlyNumber(number) {
        if (number) {
            return number.replace(/\D/g, "");
        } else {
            return "";
        }
    },
    formatCurrency(number) {
        if (number) {
            let formattedNumber = number.toString().replace(/\D/g, "");
            let rest = formattedNumber.length % 3;
            let currency = formattedNumber.substr(0, rest);
            let thousand = formattedNumber.substr(rest).match(/\d{3}/g);
            let separator;

            if (thousand) {
                separator = rest ? "." : "";
                currency += separator + thousand.join(".");
            }

            return currency;
        } else {
            return "";
        }
    },
    timeAgo(time) {
        let date = new Date(
                (time || "").replace(/-/g, "/").replace(/[TZ]/g, " ")
            ),
            diff = (new Date().getTime() - date.getTime()) / 1000,
            dayDiff = Math.floor(diff / 86400);

        if (isNaN(dayDiff) || dayDiff < 0 || dayDiff >= 31)
            return dayjs(time).format("MMMM DD, YYYY");

        return (
            (dayDiff == 0 &&
                ((diff < 60 && "just now") ||
                    (diff < 120 && "1 minute ago") ||
                    (diff < 3600 && Math.floor(diff / 60) + " minutes ago") ||
                    (diff < 7200 && "1 hour ago") ||
                    (diff < 86400 &&
                        Math.floor(diff / 3600) + " hours ago"))) ||
            (dayDiff == 1 && "Yesterday") ||
            (dayDiff < 7 && dayDiff + " days ago") ||
            (dayDiff < 31 && Math.ceil(dayDiff / 7) + " weeks ago")
        );
    },
    diffTimeByNow(time) {
        let startDate = dayjs(dayjs().format("YYYY-MM-DD HH:mm:ss").toString());
        let endDate = dayjs(
            dayjs(time).format("YYYY-MM-DD HH:mm:ss").toString()
        );

        let duration = dayjs.duration(endDate.diff(startDate));
        let milliseconds = Math.floor(duration.asMilliseconds());

        let days = Math.round(milliseconds / 86400000);
        let hours = Math.round((milliseconds % 86400000) / 3600000);
        let minutes = Math.round(((milliseconds % 86400000) % 3600000) / 60000);
        let seconds = Math.round(
            (((milliseconds % 86400000) % 3600000) % 60000) / 1000
        );

        if (seconds < 30 && seconds >= 0) {
            minutes += 1;
        }

        return {
            days: days.toString().length < 2 ? "0" + days : days,
            hours: hours.toString().length < 2 ? "0" + hours : hours,
            minutes: minutes.toString().length < 2 ? "0" + minutes : minutes,
            seconds: seconds.toString().length < 2 ? "0" + seconds : seconds,
        };
    },
    isset(obj) {
        return Object.keys(obj).length;
    },
    assign(obj) {
        return JSON.parse(JSON.stringify(obj));
    },
    delay(time) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve();
            }, time);
        });
    },
    randomNumbers(from, to, length) {
        let numbers = [0];
        for (let i = 1; i < length; i++) {
            numbers.push(Math.ceil(Math.random() * (from - to) + to));
        }

        return numbers;
    },
    replaceAll(str, find, replace) {
        return str.replace(new RegExp(find, "g"), replace);
    },
};

export default helpers;
