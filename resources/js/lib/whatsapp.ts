const COMPANY_WHATSAPP_NUMBER = '6281298765432';

export function openWhatsApp(
    message: string,
    phone: string = COMPANY_WHATSAPP_NUMBER,
): void {
    const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank', 'noopener,noreferrer');
}
