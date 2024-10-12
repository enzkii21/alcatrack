<template>
    <v-container>
        <v-card flat>
            <v-row>
                <v-col  align="center" justify="center">
                    <v-img max-height="100" max-width="450" src="images/ALUMNIS.png"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
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
                                    <v-tooltip top v-if="deletedStudents.length != 0">
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
                                        <span>RESTORE</span>
                                    </v-tooltip>
                                    <v-tooltip top >
                                        <template v-slot:activator="{on, attrs}">
                                            <span 
                                                style="font-size: xx-large;"
                                            >
                                                <v-img
                                                    class="cursor"
                                                    @click="(regDialog = true),(blnAddUpdate = 0)"
                                                    v-on="on"
                                                    v-bind="attrs"
                                                    src="images/Icons/add.png " 
                                                    max-height="30" 
                                                    max-width="30"
                                                />
                                            </span>
                                        </template>
                                        <span>ADD NEW</span>
                                    </v-tooltip>
                            </v-toolbar>
                        </template>

                        <template  v-slot:item="row">
                            <tr align="center">
                                <td>{{ row.item.StudentID }}</td>
                                <td>{{ row.item.LastName }}</td>
                                <td>{{ row.item.FirstName }}</td>
                                <td>{{ row.item.MiddleName }}</td>
                                <td>{{ row.item.Suffix }}</td>
                                <td>{{ row.item.CourseName }}</td>
                                <td>{{ row.item.Batch }}</td>
                                <!-- <td>
                                    <v-chip :color="row.item.DeletedDate == null ? 'green':'red'" small>{{ row.item.DeletedDate == null ? 'Active' : 'Deactivated'  }}</v-chip>
                                </td> -->
                                <td>
                                    <v-row>
                                        <v-col cols="6" class="pa-0">
                                            <v-tooltip right v-if="row.item.DeletedDate == null">
                                                <template v-slot:activator="{on, attrs}">
                                                    <v-btn 
                                                        v-on="on"
                                                        v-bind="attrs"
                                                        fab 
                                                        small 
                                                        dark 
                                                        color="green" 
                                                        @click="mEdit(row.item)"
                                                        >
                                                            <span  style="font-size: x-large" small dark>
                                                                <v-img max-height="25" max-width="25" src="images/Icons/edit.png"></v-img>
                                                            </span>
                                                    </v-btn>
                                                </template>
                                                <span>EDIT</span>
                                            </v-tooltip>
                                        </v-col>
                                        <v-col cols="6" class="pa-0">
                                            <v-tooltip right v-if="row.item.DeletedDate == null">
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
                                        </v-col>
                                    </v-row>
                                    
                                    <!-- <v-tooltip right v-if="row.item.DeletedDate != null">
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
                                </td>
                            </tr>
                        </template>
                    </v-data-table>

                    <template>
                        <v-dialog  v-model="dialogRestore" max-width="1000px" persistent>
                            <v-card>
                                <v-card-title  style="background-color:#404040 ;color:white">DELETED STUDENTS
                                    <v-spacer/>
                                    <span  class="cursor" @click="dialogRestore = false" >❌</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-data-table
                                        :headers="deletedheaders"
                                        :items="deletedStudents"
                                        disable-sort
                                    >
                                    <template v-slot:item="row">
                                        <tr align="center"> 
                                            <td>{{ row.item.StudentID }}</td>
                                            <td>{{ row.item.LastName }}</td>
                                            <td>{{ row.item.FirstName }}</td>
                                            <td>{{ row.item.MiddleName }}</td>
                                            <td>{{ row.item.Suffix }}</td>
                                            <td>{{ row.item.CourseName }}</td>
                                            <td>{{ row.item.Batch }}</td>
                                            <td>
                                                <v-tooltip left >
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
                        <v-dialog v-model="regDialog" max-width="400px" persistent>
                            <v-form ref="form">
                                <v-card>
                                    <v-card-title  style="background-color:#404040 ;color:white">{{ blnAddUpdate == -1 ? 'EDIT STUDENTS' : 'REGISTER STUDENTS' }}
                                        <v-spacer/>
                                        <span class="cursor" @click="mcloseRegDialog()">❌</span>
                                    </v-card-title>
                                    <v-card-text class="pt-2">
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    v-if="blnAddUpdate == -1"
                                                    @keypress="isNumber($event)"
                                                    v-model="objData.StudentID"
                                                    maxlength="11"
                                                    readonly
                                                    dense
                                                    outlined
                                                    label="Student ID"
                                                    name="StudentID"
                                                />
                                                <v-text-field
                                                    v-else
                                                    @keypress="isNumber($event)"
                                                    v-model="objData.StudentID"
                                                    maxlength="11"
                                                    dense
                                                    outlined
                                                    label="Student ID"
                                                    name="StudentID"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    v-model="objData.FirstName"
                                                    @keydown="preventSpace($event,objData.FirstName)"
                                                    @keypress="isChar($event)"
                                                    dense
                                                    outlined
                                                    label="First Name"
                                                    name="FirstName"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    v-model="objData.MiddleName"
                                                    @keydown="preventSpace($event,objData.MiddleName)"
                                                    @keypress="isChar($event)"
                                                    dense
                                                    outlined
                                                    label="Middle Name"
                                                    name="MiddleName"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    v-model="objData.LastName"
                                                    @keydown="preventSpace($event,objData.LastName)"
                                                    @keypress="isChar($event)"
                                                    required
                                                    dense
                                                    outlined
                                                    label="Last Name"
                                                    name="LastName"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    v-model="objData.Suffix"
                                                    @keydown="preventSpace($event,objData.Suffix)"
                                                    @keypress="isChar($event)"
                                                    dense
                                                    outlined
                                                    maxlength="5"
                                                    label="Suffix"
                                                    name="Suffix"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-select
                                                    v-model="objData.CourseID"
                                                    item-text="CourseName"
                                                    item-value="CourseID"
                                                    :items="avail_courses"
                                                    dense
                                                    outlined
                                                    label="Course"
                                                    name="CourseName"
                                                />
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-text-field
                                                    @keypress="isNumber($event)"
                                                    v-model="objData.Batch"
                                                    maxlength="4"
                                                    hint="e.g. 2024"
                                                    dense
                                                    outlined
                                                    label="Batch"
                                                    name="Batch"
                                                />
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn v-if="blnAddUpdate != -1" :disabled="isEnabled" @click="mInsertSave()">submit </v-btn>
                                        <v-btn v-else  @click="mInsertSave()">save</v-btn>
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
import axios from 'axios'
import Swal from 'sweetalert2'
export default {
    data: () => ({
        search: '',
        deletedStudents: [],
        deletedheaders:[
                {text:'Studen ID', align: 'center'},
                {text:'Last Name', align: 'center'},
                {text:'First Name', align: 'center'},
                {text:'Middle Name', align: 'center'},
                {text:'Suffix', align: 'center'},
                {text:'Course Name', align: 'center'},
                {text:'Batch', align: 'center'},
                {text:'Action', align: 'center'},
                
            ],
        headers:[
            {text:'Student ID', value: 'StudentID', align: 'center'},
            {text:'Last Name', value: 'LastName', align: 'center'},
            {text:'First Name', value: 'FirstName', align: 'center'},
            {text:'Middle Name', value: 'MiddleName', align: 'center'},
            {text:'Suffix', value: 'Suffix', align: 'center'},
            {text:'Course', value: 'CourseName', align: 'center'},
            {text:'Batch Year', value: 'Batch', align: 'center'},
            // {text:'Status', value: 'status', align: 'center'},
            {text:'Action', value: 'action', align: 'center'},
        ],
        selectedCourse: '',
        studentID: '',
        firstName: '',
        middleName: '',
        lastName: '',
        suffix: '',
        batch: '',
        dialogRestore: false,
        regDialog: false,
        overlay: false,
        avail_courses: [],
        items:[],
        objData: {},
        blnAddUpdate: -1,
    }),

    created() {
        this.mGetAlumnis()
        this.mgetCourses()
    },

    computed: {
        isEnabled(){
            if(!this.objData.StudentID || !this.objData.Batch|| !this.objData.CourseID|| !this.objData.FirstName
                || !this.objData.LastName ){
                return true
            }else{
                return false
            }
        }
    },

    watch: {
        
    },

    methods: {

        mEdit(items){
            this.blnAddUpdate = -1
            this.regDialog = true
            this.objData.StudentID = items.StudentID
            this.objData.FirstName = items.FirstName
            this.objData.MiddleName = items.MiddleName
            this.objData.LastName = items.LastName
            this.objData.Suffix = items.Suffix
            this.objData.CourseName = items.CourseName
            this.objData.CourseID = items.CourseID
            this.objData.Batch = items.Batch
            this.objData.oldStudentID = items.oldStudentID
            this.objData.isDeleted = items.DeletedDate

        },


        mgetDeletedStudents(){
            axios.get(`api/registeredstudents?method=GET_DELETED`)
            .then((res) =>{
                this.deletedStudents = res.data
                this.overlay = false
            })
        },

        mcloseRegDialog(){
            this.regDialog = false
            // this.selectedCourse = null
            this.objData = {};
        },

        mGetAlumnis(){
            this.overlay = true
            axios.get(`api/registeredstudents?method=GET_STUDENTS`)
            .then((res) =>{
                this.items = res.data;
                this.mgetDeletedStudents()
            })
        },

        isNumber(e) {
            let char = String.fromCharCode(e.keyCode);
            if (/^[0-9]+$/.test(char)) return true;
            else e.preventDefault();
        },

        preventSpace(e,data){
            if (e.key === ' ' && data.length === 0) {
                e.preventDefault();
                return false;
            }
        },

        isChar(e) {
            let char = String.fromCharCode(e.keyCode);
            if (/^[a-zA-Z\s]+$/.test(char)) return true;
            else e.preventDefault();
        },

        mgetCourses(){
            axios.get('api/course?method=GET_COURSES').then((res =>{
                this.avail_courses = res.data
            }))
        },

        mInsertSave(){
            this.overlay = true
            let data = {
                    oldStudentID: this.objData.oldStudentID,
                    selectedCourse: this.objData.CourseID,
                    studentID: this.objData.StudentID,
                    firstName:this.objData.FirstName,
                    middleName: this.objData.MiddleName,
                    lastName: this.objData.LastName,
                    suffix: this.objData.Suffix,
                    batch: this.objData.Batch,
                    method: 'edit'
                }
            if(this.blnAddUpdate == 0){
                axios.post(`api/registeredstudents`, data)
                .then((res)=>{
                    console.log(res.data);
                    if(res.data == 'success'){
                        this.mGetAlumnis()
                        Swal.fire({
                            title: 'Successfully Registered',
                            text: 'He/She may now make an account',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        });
                    }else if(res.data == 'exist' || res.data == 'account exist'){
                        Swal.fire({
                            title: 'Duplicate ID',
                            text: "Please try different ID",
                            showConfirmButton: false,
                            icon: 'info',
                            timer: 3000
                        });
                    }else{
                        Swal.fire({
                            title: 'Error',
                            text: 'Something happens upon registration ',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                    }
                }).finally(()=>{
                    this.regDialog = false
                    this.objData= {}
                    this.overlay = false
                })
            }else{
                axios.put(`api/registeredstudents/update`, data)
                .then((res)=>{
                    if(res.data == 'updated'){
                        this.mGetAlumnis()
                        Swal.fire({
                        title: 'Successfully Updated',
                        text: 'He/She may now make an account',
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 3000
                      });
                    }else{
                        Swal.fire({
                            title: 'Error',
                            text: 'Something happens upon updating ',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                    }
                }).finally(()=>{
                    this.regDialog = false
                    this.objData= {}
                    this.overlay = false
                })
            }
        },

        mDelete(item){
            let data = {
                    oldStudentID: item.oldStudentID,
                    selectedCourse: item.CourseID,
                    studentID: item.StudentID,
                    firstName:item.FirstName,
                    middleName: item.MiddleName,
                    lastName: item.LastName,
                    suffix: item.Suffix,
                    batch: item.Batch,
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
                    axios.put(`api/registeredstudents/update`, data)
                    .then((res)=>{
                        if(res.data == 'deleted'){
                            Swal.fire({
                                title: 'Success',
                                text: 'Data was deleted',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 3000
                            }).then(()=>{
                                this.overlay = false
                                this.mGetAlumnis()
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
                    oldStudentID: item.oldStudentID,
                    selectedCourse: item.CourseID,
                    studentID: item.StudentID,
                    firstName:item.FirstName,
                    middleName: item.MiddleName,
                    lastName: item.LastName,
                    suffix: item.Suffix,
                    batch: item.Batch,
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
                    axios.put(`api/registeredstudents/update`, data)
                    .then((res)=>{
                        this.dialogRestore = false
                        if(res.data == 'restored'){
                            this.overlay = false
                            this.mGetAlumnis()
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
                                text: 'Something happens upon restoring',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 3000
                            })
                        }
                    })
                    
                }
            })
        }
    },
}
</script>

<style >

</style>