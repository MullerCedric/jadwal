export default function (userApiToken) {
    context.token = userApiToken;

    if (route().current('exam_sessions.create') || route().current('exam_sessions.edit')) {
        context.target = route('api.draft_exam_sessions.store', {api_token: userApiToken});
        context.formEl = document.getElementById('storeForm');

        let formVar = {};
        ['location', 'title', 'indications', 'deadline', 'currentId'].forEach((id, index) => {
            formVar[id] = document.getElementById(id);
            if (formVar[id]) {
                data.set(formVar[id].getAttribute('name'), formVar[id].value);
                formVar[id].addEventListener('change', updateData, false);
            }
        });
    }
    if (route().current('messages.create') || route().current('messages.edit')) {
        context.target = route('api.draft_messages.store', {api_token: userApiToken});
        context.formEl = document.getElementById('storeForm');

        let formVar = {};
        ['exam_session', 'title', 'body', 'currentId'].forEach((id, index) => {
            formVar[id] = document.getElementById(id);
            if (formVar[id]) {
                data.set(formVar[id].getAttribute('name'), formVar[id].value);
                formVar[id].addEventListener('change', updateData, false);
            }
        });
    }
    if (route().current('preferences.create') || route().current('preferences.edit')) {
        context.target = route('api.draft_preferences.store', {api_token: userApiToken});
        context.formEl = document.getElementById('storeForm');

        let valuesArr = [];
        let formVar = {};
        for (let i = 0; document.getElementById('count' + i) && document.getElementById('count' + i).value === 'true'; i++) {
            formVar['oral' + i] = document.getElementById('oral' + i);
            formVar['written' + i] = document.getElementById('written' + i);
            if (formVar['oral' + i]) {
                if (formVar['oral' + i].checked) {
                    data.set(formVar['oral' + i].getAttribute('name'), formVar['oral' + i].value);
                }
                formVar['oral' + i].addEventListener('click', updateData, false);
            }
            if (formVar['written' + i]) {
                if (formVar['written' + i].checked) {
                    data.set(formVar['written' + i].getAttribute('name'), formVar['written' + i].value);
                }
                formVar['written' + i].addEventListener('click', updateData, false);
            }
            valuesArr = valuesArr.concat([
                'count' + i,
                'course_name' + i,
                'groups' + i,
                'groups_indications' + i,
                'rooms' + i,
                'duration' + i,
                'watched_by' + i,
            ]);
        }

        ['about', 'teacherToken', 'examSessionId', 'currentId', ...valuesArr].forEach((id, index) => {
            formVar[id] = document.getElementById(id);
            if (formVar[id]) {
                data.set(formVar[id].getAttribute('name'), formVar[id].value);
                formVar[id].addEventListener('change', updateData, false);
            }
        });
    }
}

let data = new FormData();
let context = {
    token: '',
    target: '',
    formEl: null,
    currentIdEl: null,
    lastUpdated: null,
    changesSinceUpdate: false,
    timeOut: null,
};

function updateData(e) {
    context.changesSinceUpdate = true;
    data.set(e.target.name, e.target.value);
    sendData();
}

function sendData() {
    clearTimeout(context.timeOut);
    if (wasMoreThan20SecondsAgo(context.lastUpdated) && context.changesSinceUpdate) {
        window.axios({
            method: 'post',
            url: context.target,
            data: data,
            headers: {'Content-Type': 'multipart/form-data'}
        })
            .then((response) => {
                context.currentIdEl = document.getElementById('currentId');
                if (!context.currentIdEl) {
                    context.currentIdEl = document.createElement('input');
                    context.currentIdEl.type = 'hidden';
                    context.currentIdEl.name = 'id';
                    context.currentIdEl.value = response.data.id;
                    context.currentIdEl.id = 'currentId';
                    context.formEl.appendChild(context.currentIdEl);
                    data.set('id', response.data.id);
                }
                console.log('Vos modifications ont été enregistrées en tant que brouillon');
            })
            .catch((response) => {
                console.error(response);
            });

        context.lastUpdated = new Date();
        context.changesSinceUpdate = false;
    } else {
        context.timeOut = setTimeout(sendData, 4 * 1000);
    }
}

function wasMoreThan20SecondsAgo(date = null) {
    if (!date) {
        return true;
    }
    return ((new Date()) - date) > (20 * 1000);
}
