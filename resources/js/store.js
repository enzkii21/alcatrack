import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex)
export default new Vuex.Store({
    state:{
        UserInfo:{},
    },
    actions:{},
    mutations:{
        Login_Info(state,data){
            state.UserInfo = data
        },

        Logout(state) {
            state.UserInfo = {}
        },

        UpdateProfilePic(state,payload){
            state.UserInfo.Image = payload
        },

        ClearPicture(state){
            state.UserInfo.Image = ''
        }
    },
    getters:{},
    plugins: [createPersistedState()]
});