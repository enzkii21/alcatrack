<template>
    <v-app id="inspire" class="noselect">
       <navbar></navbar>
       <!-- <v-app-bar app style="background-color: transparent;" flat v-else>
            <v-toolbar-title>
                <v-img  max-height="50" max-width="200"  src="images/Alcatrack-8-31-2024.png"></v-img>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-tooltip bottom v-if="this.$route.path == '/login'">
                <template v-slot:activator="{ on, attrs }">
                    <span
                        class="cursor"
                        v-on="on"
                        v-bind="attrs"
                        @click="GoToDashboard()"
                        style="font-size: xx-large;"
                    >🏠</span>
                </template>
                <span>Home</span>
            </v-tooltip>

            <v-tooltip bottom v-else>
                <template v-slot:activator="{ on, attrs }">
                    <span
                    class="cursor"
                        v-on="on"
                        v-bind="attrs"
                        @click="GoToLogin()"
                        style="font-size: xx-large;"
                    >🔐</span>
                </template>
                <span>Login</span>
            </v-tooltip>

        </v-app-bar> -->
       <v-main>
          <router-view></router-view>
       </v-main>
    </v-app>
</template>
<script>
import navbar from "../components/NavBar.vue"
export default {
    name: "App",
    components:{
        navbar,
    },

    created(){
        // this.checkCookie()
    },

    methods: {
        // checkCookie(){
        //     axios.get(`api/master?Process=CHECKCOOKIES&&EmployeeCode=${this.$store.state.userInfo.EmployeeCode}&&EmployeeName=${this.$store.state.userInfo.EmployeeName}`)    
        // }

        GoToLogin(){
            if(this.$route.path != '/login'){
                this.$router.push('/login')
            }
        },

        GoToDashboard(){
            if(this.$route.path != '/'){
                this.$router.push('/')
            }
        },
    }
};
</script>