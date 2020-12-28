function get_huid() {
    // Return hashed uuid
    return CryptoJS.SHA256(get_uuid()).toString();
}

function get_uuid() {
    // Get UUID
    var uuid = Cookies.get('UUID');
    if( !uuid ) {
        uuid = (Math.random().toString(36)+'0000000000').slice(2, 10);
    }
    // Extend cookie duration
    Cookies.set('UUID', uuid, { expires: 365 });
    // Return plain uuid
    return uuid.toString();
}