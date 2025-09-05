document.addEventListener('DOMContentLoaded', function() {
    const banner = document.getElementById('cookieBanner');
    const acceptBtn = document.getElementById('acceptCookiesBtn');
    const declineBtn = document.getElementById('declineCookiesBtn');

    function setCookie(name, value, days){
        let expires = "";
        if(days){
            const date = new Date();
            date.setTime(date.getTime() + (days * 24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name){
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for(let i = 0; i < ca.length ; i++){
            let c = ca[i];
            while(c.charAt(0) ===' ') c = c.substring(1,c.length);
            if(c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    if(!getCookie('cookiesAccepted')){
        setTimeout(() => banner.classList.add('show'),300);
    }

    acceptBtn.addEventListener('click', function() {
        setCookie('cookiesAccepted', 'true', 365);
        banner.classList.remove('show');
        setTimeout(() => banner.style.display = 'none', 500);
    });


    declineBtn.addEventListener('click', function() {
        banner.classList.remove('show');
        setTimeout(() => banner.style.display = 'none', 500);
    });
});
