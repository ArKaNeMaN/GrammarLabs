export function dateFormat(d) {
    let date = new Date(d);

    return date.toLocaleDateString();
}

export function answerStatusFormat(value) {
    return {
        'draft': 'Черновик',
        'sent': 'Сдано',
        'accepted': 'Принято',
        'rejected': 'Отклонено',
    }[value] ?? 'Не сдано';
}

export function answerAutoTestResultFormat(value) {
    return {
        'success': 'Пройдена',
        'failed': 'Провалена',
    }[value] ?? 'Не проверено';
}

export function taskTypeFormat(value) {
    return {
        generate: 'Генерация',
        reverse: 'Реверс',
    }[value] ?? '?';
}
