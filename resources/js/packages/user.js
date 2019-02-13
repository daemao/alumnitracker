import {get} from '../api'

export default function (Vue) {

    Vue.user = {

        data: '',
        ready: false,

        isAdministrator(){
            return this.data.role_id ==1;
        },
        isAlumni(){
            return this.data.role_id ==2;
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
