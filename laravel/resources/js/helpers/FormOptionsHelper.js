import { notify } from "./NotificationHelper.js";

export default (params = {}, preserveScroll = true) => {
    return {
        onSuccess: params.success !== false ? () => {
            notify().success(params.successMessage ?? 'Operacja przeszła pomyślnie')

            if (params.onSuccess) {
                params.onSuccess();
            }
        } : undefined,

        preserveScroll: preserveScroll,
    }
}
