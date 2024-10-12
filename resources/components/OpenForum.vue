<template>
    <v-container>
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col align="center" justify="center">
                    <v-img max-height="100" max-width="400" src="images/FORUM.png"/>
                </v-col>
            </v-row>
            <v-row  align="center" justify="center">
                <v-col align="center" justify="center">
                    <v-data-table
                        :headers="headers"
                        :items="topicList"
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
                                        solo
                                        single-line
                                        hide-details
                                        dense
                                        outlined
                                    ></v-text-field>
                                    <v-spacer></v-spacer>
                                    <v-tooltip top v-if="deletedTopicList.length != 0">
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
                                                    @click="(AddDialog = true)"
                                                    v-on="on"
                                                    v-bind="attrs"
                                                    src="images/Icons/add.png " 
                                                    max-height="30" 
                                                    max-width="30"
                                                />
                                            </span>
                                        </template>
                                        <span>ADD TOPIC</span>
                                    </v-tooltip>
                            </v-toolbar>
                        </template> 

                        <template  v-slot:item="row">
                            <tr align="center">
                                <td>{{ row.item.ForumID }}</td>
                                <td>{{ row.item.Title }}</td>
                                <td>{{ row.item.Description }}</td>
                                <td >
                                    <v-row >
                                        <v-col cols="6" class="pa-1">
                                            <v-tooltip top v-if="row.item.DeletedDate == null">
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
                                        <v-col cols="6" class="pa-1">
                                            <v-tooltip top >
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

                    <template>
                        <v-dialog v-model="AddDialog" max-width="400px" persistent>
                            <v-card>
                                <v-card-title  style="background-color:#404040 ;color:white">{{ boolUpdate == 1 ? 'EDIT TOPIC' : 'ADD TOPIC' }}
                                    <v-spacer/>
                                    <span  class="cursor" @click="closeDialog()" >❌</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-row no-gutters>
                                        <v-col cols="12">
                                            TITLE
                                        </v-col>
                                        <v-col>
                                            <v-text-field
                                                v-model="objData.Title"
                                                dense
                                                outlined
                                                maxlength="50"
                                            />
                                        </v-col>
                                    </v-row>
                                    <v-row no-gutters>
                                        <v-col cols="12">
                                            DESCRIPTION
                                        </v-col>
                                        <v-col>
                                            <v-textarea
                                                v-model="objData.Description"
                                                counter
                                                outlined
                                                maxlength="200"
                                            /> 
                                        </v-col>
                                    </v-row>
                                    
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer/>
                                    <v-btn
                                        :disabled="disableSave"
                                        @click="InsertUpdate()"
                                    >SAVE</v-btn>
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
                        </v-dialog>
                    </template>

                    <template>
                        <v-dialog  v-model="dialogRestore" max-width="700px" persistent>
                            <v-card>
                                <v-card-title  style="background-color:#404040 ;color:white">DELETED TOPICS
                                    <v-spacer/>
                                    <span  class="cursor" @click="dialogRestore = false" >❌</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-data-table
                                        :headers="headers"
                                        :items="deletedTopicList"
                                        disable-sort
                                    >
                                    <template v-slot:item="row">
                                        <tr align="center"> 
                                            <td>{{ row.item.ForumID }}</td>
                                            <td>{{ row.item.Title }}</td>
                                            <td>{{ row.item.Description }}</td>
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
                                                    <span>RESTORE</span>
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

                </v-col>
            </v-row>
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


    </v-container>
</template>

<script>
import Swal from 'sweetalert2'

export default {
    data(){
        return {
            headers:[
                {text:'ID', align: 'center'},
                {text:'Title', align: 'center'},
                {text:'Description', align: 'center'},
                {text:'Action', align: 'center'},
            ],
            search: '',
            // descriptionRules:[v => !!v || 'Description is required',v => v.length <= 200 || 'Max 200 characters'],
            // titleRules:[v => !!v || 'Title is required',v => v.length <= 50 || 'Max 50 characters'],
            AddDialog: false,
            dialogRestore: false,
            dDescription: '',
            dTitle: '',
            overlay: false,
            dialogRestore: false,
            valid: true,
            topicList: [],
            deletedTopicList: [],
            objData: [],
            boolUpdate: 0,


        }
    },


    created() {
        this.getTopics()
        
    },

    watch: {
        
    },

    computed: {
        disableSave(){
            if(this.boolUpdate == 0){
                if(!this.objData.Title ||  !this.objData.Description){
                    return true
                }else{
                    return false
                }
            }
        }
    },

    methods: {

        closeDialog(){
            this.objData = {}
            this.AddDialog = false
        },


        getDeletedTopics(){
            axios.get(`api/forum?method=GET_DELETE`)
            .then((res) =>{
                this.deletedTopicList = res.data
                this.overlay = false
            })
        },

        getTopics(){
            this.overlay = true
            axios.get(`api/forum?method=GET`)
            .then((res) =>{
                this.getDeletedTopics();
                this.topicList = res.data
            })
        },

        mEdit(item){
            this.AddDialog = true
            this.boolUpdate = 1
            this.objData.Title = item.Title
            this.objData.Description = item.Description
            this.objData.ForumID = item.ForumID
            
        },

        mRestore(item){
            this.overlay = true
            axios.put(`api/forum/update?method=RESTORE&&ID=${item.ForumID}`)
            .then((res) => {
                this.dialogRestore = false
                if(res.data == 'success'){
                    this.getTopics()
                    this.overlay = false
                    Swal.fire({
                        title: 'Successfully Restored',
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 3000
                    });
                }else{
                    this.overlay = false
                    Swal.fire({
                        title: 'Something error happened!',
                        showConfirmButton: false,
                        icon: 'error',
                        timer: 3000
                    });
                }
            })
        },

        mDelete(item){
            Swal.fire({
                title: "Are you sure?",
                text: "This data will be deleted",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "<span style='color: white;'>NO</span>",
                confirmButtonText: "<span style='color: white;'>YES</span>",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) =>{
                if(result.isConfirmed){
                    this.overlay = true
                    axios.put(`api/forum/update?method=DELETE&&ID=${item.ForumID}`)
                    .then((res) =>{
                        if(res.data == 'success'){
                            this.getTopics()
                            this.overlay = false
                            Swal.fire({
                                title: 'Successfully Deleted',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 3000
                            });
                        }else{
                            this.overlay = false
                            Swal.fire({
                                title: 'Something error happened!',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 3000
                            });
                        }
                    })
                }
            })
        },

        InsertUpdate () {
            this.overlay = true
            if(this.boolUpdate == 0){
                axios.post(`api/forum?Title=${this.objData.Title}&&Description=${this.objData.Description}`)
                .then((res) =>{
                    if(res.data =='success'){
                        this.overlay = false
                        this.AddDialog = false
                        this.getTopics()
                        this.objData = {}
                        Swal.fire({
                            title: 'Successfully Added',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        });
                    }else{
                        this.overlay = false
                        Swal.fire({
                            title: 'Something error happened!',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                    }
                })
            }else{
                axios.put(`api/forum/update?method=EDIT&&Title=${this.objData.Title}&&Description=${this.objData.Description}&&ID=${this.objData.ForumID}`)
                .then((res) =>{
                    if(res.data == 'success'){
                        this.AddDialog = false
                        this.objData = {}
                        this.overlay = false
                        this.getTopics()
                        Swal.fire({
                            title: 'Successfully Changed!',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        });
                    }else{
                        this.overlay = false
                        Swal.fire({
                            title: 'Something error happened!',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                    }
                })
            }
        },
    },
}

</script>