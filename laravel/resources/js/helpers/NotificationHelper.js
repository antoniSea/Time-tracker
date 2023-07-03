import { Notyf } from "notyf";
import 'notyf/notyf.min.css';

const notify = () => {
    return new Notyf();
};

export {
    notify,
}
