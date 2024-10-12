<template>
    <v-container>
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col align="center" justify="center">
                    <v-img max-height="100" max-width="400" src="images/COURSES.png"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-data-table
                        :headers="headers"
                        :items="courseList"
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
                                    <v-tooltip top v-if="deletedCourse.length != 0">
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
                                                style="font-size: large;"
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
                                        <span>ADD COURSE</span>
                                    </v-tooltip>
                            </v-toolbar>
                        </template> 

                        <template  v-slot:item="row">
                            <tr align="center">
                                <td>{{ row.item.CourseName }}</td>
                                <td>{{ row.item.CourseAbvr }}</td>
                                <td>
                                    <v-row align="center" justify="center">
                                        <v-col cols="3" class="pa-0">
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
                                        <v-col cols="3" class="pa-0">
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
                                </td>
                            </tr>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-card>

        <template>
            <v-dialog v-model="regDialog" max-width="400px" persistent>
                <v-card>
                    <v-card-title  style="background-color:#404040 ;color:white">{{ blnAddUpdate == -1 ? 'EDIT COURSE' : 'REGISTER COURSE' }}
                        <v-spacer/>
                        <span class="cursor" @click="mcloseRegDialog()">❌</span>
                    </v-card-title>
                    <v-card-text class="pt-2 pb-0">
                        <v-row no-gutters>
                            <v-col>
                                <v-text-field
                                    dense
                                    outlined
                                    label="Course Name"
                                    v-model="objData.CourseName"
                                />
                            </v-col>
                        </v-row>
                        <v-row no-gutters>
                            <v-col>
                                <v-text-field
                                    dense
                                    outlined
                                    label="Course Abvr"
                                    v-model="objData.CourseAbvr"
                                />
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn v-if="blnAddUpdate != -1" :disabled="isEnabled" @click="mInsertSave()">submit </v-btn>
                        <v-btn v-else  @click="mInsertSave()">save</v-btn>
                    </v-card-actions>

                </v-card>
            </v-dialog>
        </template>


        <template>
            <v-dialog v-model="dialogRestore" max-width="700px" persistent>
                <v-card>
                    <v-card-title  style="background-color:#404040 ;color:white">DELETED COURSES
                        <v-spacer/>
                        <span  class="cursor" @click="dialogRestore = false" >❌</span>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table
                            :headers="deletedHeaders"
                            :items="deletedCourse"
                            disable-sort
                        >
                        <template v-slot:item="row">
                            <tr align="center"> 
                                <td>{{ row.item.CourseName }}</td>
                                <td>{{ row.item.CourseAbvr }}</td>
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
            </v-dialog>
        </template>



    </v-container>
</template>

<script>
import Swal from 'sweetalert2'
export default {
    data(){
        return{
            search: '',
            dialogRestore: false,
            deletedCourse: [],
            deletedHeaders:[
                {text:'Course Name', align:'center'},
                {text:'Course Abvr', align:'center'},
                {text:'Action', align:'center'},
            ],
            headers:[
                {text:'Course Name', align:'center'},
                {text:'Course Abvr', align:'center'},
                {text:'Action', align:'center'},
            ],
            courseList: [],
            regDialog: false,
            objData: {},
            blnAddUpdate: -1
        }
    },

    created() {
        this.mgetCourse()
    },

    watch: {
        
    },

    computed: {
        isEnabled(){
            if(!this.objData.CourseName|| !this.objData.CourseAbvr ){
                return true
            }else{
                return false
            }
        }
    },

    methods: {

        mEdit(items){
            this.blnAddUpdate = -1
            this.regDialog = true
            this.objData.CourseName = items.CourseName
            this.objData.CourseAbvr = items.CourseAbvr
            this.objData.CourseID = items.CourseID

        },

        mgetDeletedCourse(){
            axios.get('api/course?method=GET_DELETED')
            .then((res) =>{
                this.deletedCourse = res.data
            })
        },
        
        mgetCourse(){
            axios.get('api/course?method=GET_COURSES')
            .then((res) =>{
                this.mgetDeletedCourse()
                this.courseList = res.data
            })
        },

        mcloseRegDialog(){
            this.objData= {}
            this.regDialog = false
        },

        mInsertSave(){
            let data = {
                CourseName: this.objData.CourseName,
                CourseAbvr: this.objData.CourseAbvr,
                CourseID: this.objData.CourseID,
                method: 'edit'
            }
            if(this.blnAddUpdate == 0){
                axios.post('api/course', data)
                .then((res) =>{
                    if(res.data == 'success'){
                        this.mgetCourse()
                        this.mcloseRegDialog()
                        Swal.fire({
                            title: 'Successfully Registered',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        });
                    }else{
                        this.mcloseRegDialog()
                        Swal.fire({
                            title: 'Error',
                            text: 'Something happens upon updating ',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                    }
                })
            }else{
                axios.put(`api/course/update`, data)
                .then((res) =>{
                    if(res.data == 'updated'){
                        this.mgetCourse()
                        this.mcloseRegDialog()
                        Swal.fire({
                            title: 'Successfully Updated',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        });
                    }else{
                        this.mcloseRegDialog()
                        Swal.fire({
                            title: 'Error',
                            text: 'Something happens upon updating ',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                    }
                })
            }
        },

        mRestore(item){
            let data = {
                CourseID: item.CourseID,
                method: 'restore'
            }
            axios.put(`api/course/update`, data)
            .then((res) =>{
                if (res.data == 'restore'){
                    this.dialogRestore = false
                    this.mgetCourse()
                    Swal.fire({
                        title: 'Successfully Restored',
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 3000
                    })
                }else{
                    this.dialogRestore = false
                    Swal.fire({
                        title: 'Error',
                        text: 'Something happens upon restoring ',
                        showConfirmButton: false,
                        icon: 'error',
                        timer: 3000
                    })
                }
            })
        },

        mDelete(items){
           let data = {
                CourseName: items.CourseName,
                CourseID: items.CourseID,
                CourseAbvr: items.CourseAbvr,
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
            }).then((result) =>{
                if(result.isConfirmed){
                    axios.put(`api/course/update`, data)
                    .then((res) =>{
                        if(res.data == 'deleted'){
                            this.mgetCourse()
                            Swal.fire({
                                title: 'Successfully Deleted',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 3000
                            })
                        }else{
                            Swal.fire({
                            title: 'Error',
                            text: 'Something happens upon updating ',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                        }
                    })
                }
            })
        }
    },
}
// I, I just woke up from a dream
// Where you and I had to say goodbye
// And I don't know what it all means
// But since I survived, I realized

// Wherever you go, that's where I'll follow
// Nobody's promised tomorrow
// So I'ma love you every night like it's the last night
// Like it's the last night

// If the world was ending
// I'd wanna be next to you
// If the party was over
// And our time on Earth was through
// I'd wanna hold you just for a while
// And die with a smile
// If the world was ending
// I'd wanna be next to you

// (Ooh, ooh)

// Ooh, lost, lost in the words that we scream
// I don't even wanna do this anymore
// 'Cause you already know what you mean to me
// And our love's the only war worth fighting for

// Wherever you go, that's where I'll follow
// Nobody's promised tomorrow
// So I'ma love you every night like it's the last night
// Like it's the last night

// If the world was ending
// I'd wanna be next to you
// If the party was over
// And our time on Earth was through
// I'd wanna hold you just for a while
// And die with a smile
// If the world was ending
// I'd wanna be next to you

// Right next to you
// Next to you
// Right next to you
// Oh-oh

// If the world was ending
// I'd wanna be next to you
// If the party was over
// And our time on Earth was through
// I'd wanna hold you just for a while
// And die with a smile
// If the world was ending
// I'd wanna be next to you
// If the world was ending
// I'd wanna be next to you

// (Ooh, ooh)
// I'd wanna be next to you
</script>


