<template>
    <v-container>
        <v-card flat>
            <v-row align="center" justify="center"> 
                <v-col align="center" justify="center">
                    <v-img max-height="100" max-width="450" src="images/ACCOUNTS.png"/>
                </v-col>
            </v-row>
            <v-row align="center" justify="center">
                <v-col  cols="12">
                    <v-data-table
                        :headers="headers"
                        :items="items"
                        :search="search"
                        disable-sort
                    >
                        <template v-slot:top >
                            <v-toolbar flat>
                                <v-spacer></v-spacer>
                                    <v-text-field 
                                        v-model="search"
                                        append-icon="mdi-magnify"
                                        label="Search"
                                        single-line
                                        solo
                                        hide-details
                                        dense
                                        outlined
                                    ></v-text-field>
                                    <v-spacer></v-spacer>
                                    <v-tooltip top v-if="deletedAccounts.length != 0">
                                        <template v-slot:activator="{on, attrs}">
                                            <span 
                                                style="font-size: large;"
                                            >
                                            <v-img
                                                class="cursor"
                                                @click="dialogRestore = true"
                                                v-on="on"
                                                v-bind="attrs"
                                                src="images/Icons/restore.png " 
                                                max-height="30" 
                                                max-width="30"
                                            />
                                            </span>
                                        </template>
                                        <span>RESOTRE ACCOUNT</span>
                                    </v-tooltip>
                                    <v-tooltip top >
                                        <template v-slot:activator="{on, attrs}">
                                            <span 
                                                style="font-size: xx-large;"
                                            >
                                                <v-img
                                                    class="cursor"
                                                    @click="(registerAccDialog = true),(tab = 0)"
                                                    v-on="on"
                                                    v-bind="attrs"
                                                    src="images/Icons/add.png " 
                                                    max-height="30" 
                                                    max-width="30"
                                                />
                                            </span>
                                        </template>
                                        <span>ADD ADMIN</span>
                                    </v-tooltip>
                            </v-toolbar>
                        </template>

                        <template  v-slot:item="row">
                            <tr align="center">
                                <td>{{ row.item.AlumniID }}</td>
                                <td>{{ row.item.LastName }}</td>
                                <td>{{ row.item.FirstName }}</td>
                                <td>{{ row.item.MiddleName }}</td>
                                <td>{{ row.item.Suffix }}</td>
                                <td>{{ row.item.UserTypeID != 1 ? row.item.CourseName : 'N/A' }}</td>
                                <td>{{ row.item.UserTypeID != 1 ? row.item.Batch : 'N/A' }}</td>
                                <td>
                                    <v-tooltip top >
                                        <template v-slot:activator="{on, attrs}">
                                            <v-btn 
                                                v-on="on"
                                                v-bind="attrs"
                                                small 
                                                dark  
                                                @click="mShowDetail(row.item)"
                                                >
                                                    <span  style="font-size: x-large" small dark>...</span>
                                            </v-btn>
                                        </template>
                                        <span>SEE FULL DETAILS</span>
                                    </v-tooltip>
                                </td>
                                <td>
                                    <!-- <v-chip dark :color="row.item.DeletedDate == null ? 'green':'red'" small>{{ row.item.DeletedDate == null ? 'Active' : 'Deactivated'  }}</v-chip> -->
                                    <v-chip dark color="blue" v-if="row.item.UserTypeID == 1" small>Admin</v-chip>
                                    <v-chip dark color="green" v-else small>Member</v-chip>
                                </td>
                                <td>
                                    <!-- <v-tooltip left v-if="row.item.DeletedDate != null">
                                        <template v-slot:activator="{on, attrs}">
                                            <v-btn 
                                                v-on="on"
                                                v-bind="attrs"
                                                fab 
                                                small 
                                                dark 
                                                color="orange" 
                                                @click="mRestore(row.item)"
                                                >
                                                    <span  style="font-size: x-large" small dark>♻️</span>
                                            </v-btn>
                                        </template>
                                        <span>Restore</span>
                                    </v-tooltip> -->
                                    <v-tooltip top v-if="row.item.DeletedDate == null">
                                        <template v-slot:activator="{on, attrs}">
                                            <v-btn 
                                                v-on="on"
                                                v-bind="attrs"
                                                fab 
                                                small 
                                                dark 
                                                color="red" 
                                                @click="mDelete(row.item)"
                                                >
                                                    <span  style="font-size: x-large" small dark>
                                                        <v-img max-height="25" max-width="25" src="images/Icons/trash.png"></v-img>
                                                    </span>
                                            </v-btn>
                                        </template>
                                        <span>DELETE</span>
                                    </v-tooltip>
                                </td>
                            </tr>
                        </template>
                    </v-data-table>


                    <template>
                        <v-dialog  v-model="dialogRestore" max-width="1000px" persistent>
                            <v-card>
                                <v-card-title  style="background-color:#404040 ;color:white">DELETED ACCOUNTS
                                    <v-spacer/>
                                    <span  class="cursor" @click="dialogRestore = false" >❌</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-data-table
                                        :headers="deletedheaders"
                                        :items="deletedAccounts"
                                        disable-sort
                                    >
                                    <template v-slot:item="row">
                                        <tr align="center"> 
                                            <td>{{ row.item.AlumniID }}</td>
                                            <td>{{ row.item.LastName }}</td>
                                            <td>{{ row.item.FirstName }}</td>
                                            <td>{{ row.item.MiddleName }}</td>
                                            <td>{{ row.item.Suffix }}</td>
                                            <td>{{ row.item.CourseName }}</td>
                                            <td>{{ row.item.Batch }}</td>
                                            <td>
                                                <v-tooltip top >
                                                    <template v-slot:activator="{on, attrs}">
                                                        <v-btn 
                                                            v-on="on"
                                                            v-bind="attrs"
                                                            fab 
                                                            small 
                                                            dark 
                                                            color="orange" 
                                                            @click="mRestore(row.item)"
                                                            >
                                                                <span  style="font-size: x-large" small dark>
                                                                    <v-img max-height="25" max-width="25" src="images/Icons/restore.png"></v-img>
                                                                </span>
                                                        </v-btn>
                                                    </template>
                                                    <span>Restore</span>
                                                </v-tooltip>
                                            </td>
                                        </tr>
                                    </template>

                                    </v-data-table>
                                </v-card-text>
                            </v-card>

                            <template>
                                <v-overlay :value="overlay">
                                    <div class="spinner">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    </div>
                                </v-overlay>
                            </template>
                        </v-dialog>
                    </template>

                    <template>
                        <v-dialog v-model="accDialog" max-width="400px" >
                            <v-form ref="form">
                                <v-card>
                                    <v-card-title  style="background-color:#404040 ;color:white">ACCOUNT DETAILS
                                        <v-spacer/>
                                        <span class="cursor" @click="accDialog = false">❌</span>
                                    </v-card-title>
                                    <v-card-text class="pt-2">
                                    <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    readonly
                                                    v-model="birthDate"
                                                    required
                                                    dense
                                                    outlined
                                                    label="Birth Date"
                                                />
                                            </v-col>
                                    </v-row>
                                    <v-row no-gutters> 
                                            <v-col>
                                                <v-text-field
                                                    readonly
                                                    v-model="age"
                                                    required
                                                    dense
                                                    outlined
                                                    label="Age"
                                                />
                                            </v-col>
                                    </v-row>
                                    <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    readonly
                                                    v-model="username"
                                                    required
                                                    dense
                                                    outlined
                                                    label="Username"
                                                />
                                            </v-col>
                                    </v-row>
                                    <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    readonly
                                                    v-model="password"
                                                    required
                                                    dense
                                                    outlined
                                                    label="Password"
                                                />
                                            </v-col>
                                    </v-row>
                                    <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    readonly
                                                    v-model="email"
                                                    required
                                                    dense
                                                    outlined
                                                    label="Email"
                                                />
                                            </v-col>
                                    </v-row>
                                    <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    readonly
                                                    v-model="contactNo"
                                                    required
                                                    dense
                                                    outlined
                                                    label="Contact Number"
                                                />
                                            </v-col>
                                    </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn></v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-form>

                            <template>
                                <v-overlay :value="overlay">
                                    <div class="spinner">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    </div>
                                </v-overlay>
                            </template>
                        </v-dialog>
                    </template>


                    <template>
                        <v-dialog v-model="registerAccDialog"  max-width="400px" persistent>
                            <v-form>
                                <v-card  >
                                    <v-card-title  style="background-color:#404040 ;color:white">NEW ADMIN
                                        <v-spacer/>
                                        <span class="cursor" @click="mcloseRegDialog()">❌</span>
                                    </v-card-title>
                                    <v-card-text class="pt-2">
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    @keypress="isChar($event)"
                                                    @keydown="preventSpace($event,reg_surname)"
                                                    dense
                                                    outlined
                                                    label="Surname"
                                                    v-model="reg_surname"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    @keypress="isChar($event)"
                                                    @keydown="preventSpace($event,reg_firstname)"
                                                    dense
                                                    outlined
                                                    label="First Name"
                                                    v-model="reg_firstname"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    @keypress="isChar($event)"
                                                    @keydown="preventSpace($event,reg_middlename)"
                                                    dense
                                                    outlined
                                                    label="Middle Name"
                                                    v-model="reg_middlename"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    @keypress="isChar($event)"
                                                    @keydown="preventSpace($event,reg_suffix)"
                                                    dense
                                                    outlined
                                                    label="Suffix"
                                                    v-model="reg_suffix"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    dense
                                                    outlined
                                                    label="Username"
                                                    v-model="reg_username"
                                                    @keydown="preventSpace($event,reg_username)" 
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    dense
                                                    outlined
                                                    label="Password"
                                                    v-model="reg_password"
                                                    :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
                                                    @click:append="showPass = !showPass"
                                                    :type="showPass ? 'text' : 'password'"
                                                    @keydown="preventSpace($event,reg_password)" 
                                                />
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer/>
                                        <v-btn :disabled="isEnabled" @click="msubmitReg()">SUBMIT</v-btn>

                                    </v-card-actions>

                                    <template>
                                        <v-overlay :value="overlay">
                                            <div class="spinner">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            </div>
                                        </v-overlay>
                                    </template>

                                </v-card>
                            </v-form>
                        </v-dialog>
                    </template>

                    <template>
                        <v-overlay :value="overlay">
                            <div class="spinner">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            </div>
                        </v-overlay>
                    </template>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>



<script>
import moment from 'moment'
import Swal from 'sweetalert2'
export default {
    data(){
        return{
            search: '',
            deletedAccounts: [],
            deletedheaders:[
                {text:'Alumni ID', align: 'center'},
                {text:'Last Name', align: 'center'},
                {text:'First Name', align: 'center'},
                {text:'Middle Name', align: 'center'},
                {text:'Suffix', align: 'center'},
                {text:'Course Name', align: 'center'},
                {text:'Batch', align: 'center'},
                {text:'Action', align: 'center'},
                
            ],
            headers:[
                {text:'Alumni ID', value: 'StudentID', align: 'center'},
                {text:'Last Name', value: 'LastName', align: 'center'},
                {text:'First Name', value: 'FirstName', align: 'center'},
                {text:'Middle Name', value: 'MiddleName', align: 'center'},
                {text:'Suffix', value: 'Suffix', align: 'center'},
                {text:'Course', value: 'CourseName', align: 'center'},
                {text:'Batch Year', value: 'Batch', align: 'center'},
                {text:'Details', value: 'details', align: 'center'},
                {text:'User Type', value: 'status', align: 'center'},
                {text:'Action', value: 'action', align: 'center'},
            ],
            dialogRestore: false,
            accDialog: false,
            overlay: false,
            registerAccDialog: false,
            showPass: false,
            blnAddUpdate: -1,
            items: [],
            age: '',
            username: '',
            password: '',
            email: '',
            birthDate: '',
            contactNo: '',
            // tab: '',
            // menu1: false,
            // formatFirstDate:'',
            // birthDate: '',
            reg_surname: '',
            reg_firstname: '',
            reg_middlename: '',
            reg_suffix: '',
            reg_username: '',
            reg_password: '',

        }
    },

    created() {
        this.mgetAccounts()
        // this.mgetCourses()
    },

    computed: {
        // ageComputed() {
        //     if (!this.formatFirstDate) {
        //     return '';
        //     }

        //     const currentDate = moment();
        //     const birthMoment = moment(this.birthDate);

        //     const ageYears = currentDate.diff(birthMoment, 'years');


        //     return ageYears;
        // },

        isEnabled(){
            if(this.reg_password == '' || this.reg_username == '' 
            ||  this.reg_firstname == '' || this.reg_surname == '' ){
                return true
            }else{
                return false
            }
        }

    },

    watch: {
        
    },

    methods: {

        updateFormattedDates(){
            this.formatFirstDate = this.birthDate
            this.menu1 = false
        },

        isNumber(e) {
            let char = String.fromCharCode(e.keyCode);
            if (/^[0-9]+$/.test(char)) return true;
            else e.preventDefault();
        },

        isChar(e) {
            let char = String.fromCharCode(e.keyCode);
            if (/^[a-zA-Z\s]+$/.test(char)) return true;
            else e.preventDefault();
        },

        preventSpace(e,data){
            if (e.key === ' ' && data.length === 0) {
                e.preventDefault();
                return false;
            }
        },

        mgetDeletedAccounts(){
            axios.get(`api/accounts?method=GET_DELETEDACCOUNT`)
            .then((res =>{
                this.deletedAccounts = res.data
                this.overlay = false
            }))
        },

        mgetAccounts(){
            this.overlay = true
            axios.get(`api/accounts?method=GET_ACCOUNT`)
            .then((res)=>{
                this.items = res.data
                this.mgetDeletedAccounts()
            })
        },


        mShowDetail(item){
            this.accDialog = true
            this.birthDate = item.UserTypeID != 1 ? moment(item.BirthDate).format('YYYY-MM-DD') : 'N/A'
            this.age = item.UserTypeID != 1 ? item.Age : 'N/A'
            this.username = item.Username
            this.password = item.Password
            this.email = item.Email
            this.contactNo = item.ContactNumber
        },

        mDelete(item){
            let data = {
                AlumniID: item.AlumniID,
                method: 'delete'
            }
            Swal.fire({
                title: "Are you sure?",
                text: "User will be deleted",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "<span style='color: white;'>NO</span>",
                confirmButtonText: "<span style='color: white;'>YES</span>",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.overlay = true
                    axios.put(`api/accounts/update`, data)
                    .then((res)=>{
                        console.log(res.data);
                        if(res.data == 'deleted'){
                            Swal.fire({
                                title: 'Success',
                                text: 'Data was deleted',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 3000
                            }).then(()=>{
                                this.overlay = false
                                this.mgetAccounts()
                            });
                        }else{
                            Swal.fire({
                                title: 'Error',
                                text: 'Something happens upon deleting ',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 3000
                            }).then(()=>{
                                this.overlay = false
                            });
                        }
                    })
                    
                }
            })
        },


        mRestore(item){
            let data = {
                AlumniID: item.AlumniID,
                method: 'restore'
            }
            Swal.fire({
                title: "Are you sure?",
                text: "User will be restored",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "<span style='color: white;'>NO</span>",
                confirmButtonText: "<span style='color: white;'>YES</span>",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.overlay = true
                    axios.put(`api/accounts/update`, data)
                    .then((res)=>{
                        this.dialogRestore = false
                        this.overlay = false
                        this.mgetAccounts()
                        if(res.data == 'restored'){
                            Swal.fire({
                                title: 'Success',
                                text: 'Data was restored',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 3000
                            })
                        }else{
                            this.overlay = false
                            Swal.fire({
                                title: 'Error',
                                text: 'Something happens upon restoring ',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 3000
                            })
                        }
                    })
                    
                }
            })
        },

        mcloseRegDialog(){
            this.registerAccDialog = false
            this.reg_surname = ''
            this.reg_firstname = ''
            this.reg_middlename = ''
            this.reg_suffix = ''
            this.reg_username = ''
            this.reg_password = ''
        },


        msubmitReg(){
            this.overlay = true
            let data = {
                Surname: this.reg_surname,
                FirstName: this.reg_firstname,
                MiddleName: this.reg_middlename,
                Suffix: this.reg_suffix,
                Username: this.reg_username,
                Password: this.reg_password,
                
            }
            axios.post(`api/accounts`, data)
            .then((res)=>{
                if(res.data == 'Success'){
                    this.mgetAccounts()
                    Swal.fire({
                        title: 'Registered Successfully',
                        text: 'Data was inserted',
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 3000
                    }).then(()=>{
                        this.overlay = false
                        this.registerAccDialog = false
                        
                    });
                }else{
                    Swal.fire({
                        title: 'Error',
                        text: res.data,
                        showConfirmButton: false,
                        icon: 'error',
                        timer: 3000
                    }).then(()=>{
                        this.overlay = false
                    });
                }
            })
        }

    },

    
}

</script>



<style>

</style>