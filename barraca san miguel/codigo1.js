function openLink(service) {
    let url = '';
    switch(service) {
        case 'telegram':
            url = 'http://t.me/Brayansuntura';
            break;
        case 'facebook':
            url = 'https://www.facebook.com/share/zJrjPEtPcRFcguPf/?mibextid=qi2Omg';
            break;
        case 'whatsapp':
            url = 'https://wa.me/qr/EGNQSOTZUPKLK1';
            break;
    }
    window.open(url, '_blank');
}

