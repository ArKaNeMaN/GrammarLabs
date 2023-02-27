export function dateFormat(d) {
    let date = new Date(d);

    return date.toLocaleDateString();
}
