import dayjs from 'dayjs';
import LocalizedFormat from 'dayjs/plugin/localizedFormat.js';
import 'dayjs/locale/fr.js';

dayjs.extend(LocalizedFormat)

dayjs.locale('fr');
dayjs.locale('en');

export function formatDate(date) { return dayjs(date).format('LL'); }

export default dayjs;
