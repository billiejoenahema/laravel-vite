import dayjs from "dayjs";

// 日付フォーマット
export const formatDate = (date, format = "YYYY年MM月DD日") => {
  if (!date) return "";
  return dayjs(date).format(format);
};
