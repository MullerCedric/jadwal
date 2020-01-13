export default function () {
    return new Promise((resolve, reject) => {
        if (localStorage.getItem('userApiToken')) {
            resolve(localStorage.getItem('userApiToken'));
        } else {
            window.axios.get(route('user.fetchApiToken'))
                .then(response => {
                    localStorage.setItem('userApiToken', response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                })
        }
    });
}
