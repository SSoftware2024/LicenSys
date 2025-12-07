import { TZDate } from "@date-fns/tz";
import { format } from "date-fns";
const timezone = "America/Fortaleza";
const date = {
    formatDate: (value, string_format = 'dd/MM/yyyy H:mm:ss') => {
        let date = new TZDate(value, timezone);
        return format(date, string_format).toString()
    }
}

export default date;
