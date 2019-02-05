import {get} from '../api'

export default function (Vue) {

    Vue.user = {

        data: '',
        ready: false,


        init(_this, callback) {
            console.log("userInit")
            let component = this;
            get(_this, '/api/user', function (response) {
                console.log(response);
                component.data = response.data;
                component.ready = true;
                _this.$root.user = data;
                _this.$root.userReady = true;

                callback();

            }, function () {

            });

        },

        getName() {

            return this.data ? this.data.name : '';

        },
        isAdministrator(){
            return this.data.role_id ==1;
        },

        getId() {
            return this.data.id;
        },

        getPhotoThumb() {
            return this.data.photo ? this.data.photo : 'http://placehold.it/36x36';
        },

        getLocale() {
            // this.$root.user.getLocale();
            return this.data.locale_id;
        }

    };

    Object.defineProperties(Vue.prototype, {
        $user: {
            get() {
                return Vue.user;
            }
        }
    })

}
