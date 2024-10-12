<template>
    <v-layout>
        <v-container fluid>
            <v-row>
                <v-col>
                    <v-carousel
                        cycle
                        height="500"
                        hide-delimiter-background
                        hide-delimiters
                        show-arrows-on-hover
                    >
                        <v-carousel-item
                            v-for="(item, i) in images"
                            :key="i"
                            ripple
                            eager
                            
                        >
                            <v-img
                                :src="item.path"
                                contain
                                max-height="900px"
                            />
                            <!-- <v-sheet :color="item.color" height="100%">
                                <v-card color="transparent" elevation="0">
                                    <v-row>
                                        <v-col cols="6">
                                            <v-card-text  
                                                style="color: white; font-size:large"
                                            ></v-card-text>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-card-text  
                                                style="color: white; font-size:large"
                                            ></v-card-text>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-card-text  
                                                style="color: white; font-size:large"
                                            ></v-card-text>
                                        </v-col>
                                    </v-row>
                                    <v-row no gutters>
                                        <v-col cols="6">
                                            <v-card-title style="color: white;"><h1>Title</h1></v-card-title>
                                            <v-card-text  
                                                style="color: white;"
                                            >
                                                <h2>{{ item.text }}</h2>
                                            </v-card-text>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-sheet> -->
                        
                        </v-carousel-item>
                    </v-carousel>
                </v-col>
            </v-row>
            
            <v-row v-if="cMyCredential">
                <v-col >
                    <v-card flat>
                        <v-card-text>
                            <v-img
                                class="mx-auto"
                                max-width="600"
                                src="images/Announcement.png" 
                            />
                            
                            <v-data-table
                                :headers="computedHeaders"
                                :items="PDFfiles"
                                disable-sort
                                class="flex-column"
                                :search="search"
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
                                            <v-tooltip top v-if="MyCredential">
                                                <template v-slot:activator="{on, attrs}">
                                                    <span 
                                                        class="cursor"
                                                        @click="UploadDialog = true"
                                                        v-on="on"
                                                        v-bind="attrs"
                                                        style="font-size: xx-large;"
                                                    >
                                                        <v-img max-height="40" max-width="40" src="images/Icons/upload.png"></v-img>
                                                    </span>
                                                </template>
                                                <span>UPLOAD</span>
                                            </v-tooltip>
                                    </v-toolbar>
                                </template>

                                <template v-slot:item="row">
                                    <tr align="center">
                                        <td >{{ row.item.PdfID }}</td>
                                        <td>{{ row.item.Description }}</td>
                                        <td>{{ row.item.CreatedDate }}</td>
                                        <td>
                                            <a :href="'storage/UploadPDF/' + row.item.PdfName" target="_blank">
                                                <v-btn fab small dark color="success">
                                                    <span style="font-size: x-large">
                                                        <v-img max-height="25" max-width="25" src="images/Icons/view.png"></v-img>
                                                    </span>
                                                </v-btn>
                                            </a>
                                        </td>
                                        <td v-if="MyCredential">
                                            <v-tooltip top >
                                                <template v-slot:activator="{on, attrs}">
                                                    <v-btn 
                                                        v-on="on"
                                                        v-bind="attrs"
                                                        fab 
                                                        small 
                                                        dark 
                                                        color="red" 
                                                        @click="mconfirmationDeleteDialog(row.item)">
                                                            <span  style="font-size: x-large">
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
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-row  v-if="cMyCredential">
                <v-col >
                    <v-card flat>
                        <v-card-text>
                            <v-row align="center" justify="center">
                                <v-col  align="center" justify="center">
                                    <v-img
                                        class="mx-auto"
                                        max-width="300"
                                        src="images/forum.png" 
                                    />
                                </v-col>
                            </v-row>
                            <v-row v-if="topicList.length == 0">
                                <v-col align="center" justify="center">
                                   <h1  style="color:rgb(202, 198, 198)">NO DATA FOUND</h1>
                                </v-col>
                            </v-row>
                            <v-row v-else align="center" justify="center" v-for="(items,i) in ctopicList" :key="i" @click="showCommentSection(items)">
                                <v-col cols="12" align="center" justify="center">
                                    <v-hover>
                                        <template v-slot:default="{hover}">
                                            <v-card :style="hover ? 'border: 1px solid black' : 'border: 1px solid #c5aa6a'" :elevation="hover ? 24: ''" outlined  class="rounded-xl" >
                                                <div  class="d-flex justify-end pr-3">
                                                    <span style="color:dimgray" >Posted : {{ moment(items.CreatedDate).calendar() }}</span>
                                                </div>
                                                
                                                <v-card-title class="justify-center pt-0">
                                                    <b>{{items.Title.toUpperCase()}}</b>
                                                
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-row align="center" justify="center">
                                                        {{ items.Description }}
                                                    </v-row>
                                                    <v-row align="center" justify="center">
                                                        <v-chip label color="#4c3c3c" dark small>
                                                            <v-icon small left>mdi-message</v-icon>
                                                            {{ items.count ? items.count : 0 }} comments
                                                            
                                                        </v-chip>
                                                        
                                                    </v-row>
                                                </v-card-text>
                                            </v-card>
                                        </template>
                                    </v-hover>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>

                    <template>
                        <v-pagination
                            :total-visible="5"
                            prev-icon="mdi-menu-left"
                            next-icon="mdi-menu-right"
                            :length="ctopicListpage"
                            v-model="pageNumber"
                        />
                    </template>
                    
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-card >
                        <v-row align="center" justify="center">
                            <v-col  align="center" justify="center">
                                <v-img
                                    class="mx-auto"
                                    max-width="300"
                                    src="images/VISION.png" 
                                />
                            </v-col>
                        </v-row>
                        <v-row align="center" justify="center">
                            <v-col  align="center" justify="center">
                                <v-card-text class="card-text">
                                    A center of human development committed to the pursuit of wisdom,truth,
                                    justice, pride, dignity, local and global competitiveness via  a quality but free 
                                    education for qualifed clients.
                               </v-card-text>
                            </v-col>
                        </v-row>
                        <v-row align="center" justify="center">
                            <v-col  align="center" justify="center">
                                <v-img
                                    class="mx-auto"
                                    max-width="350"
                                    src="images/MISSION.png" 
                                />
                            </v-col>
                        </v-row>
                        <v-row align="center" justify="center">
                            <v-col  align="center" justify="center">
                                <v-card-text class="card-text">
                                    Establish and maintain an academic promoting the pursuit of excellence and the total
                                    development of its students as a human being, with fear of God and love of country
                                    and fellowmen.
                               </v-card-text>
                            </v-col>
                        </v-row>
                        <v-row align="center" justify="center">
                            <v-col  align="center" justify="center">
                                <v-img
                                    class="mx-auto"
                                    max-width="280"
                                    src="images/GOAL.png" 
                                />
                            </v-col>
                        </v-row>
                        <v-row align="center" justify="center">
                            <v-col  align="center" justify="center">
                                <v-card-text class="card-text">
                                    <v-row>
                                       <v-col cols="1">
                                            <v-icon small>mdi-circle</v-icon>
                                       </v-col>
                                        <v-col>
                                            Foster the spiritual, intellectual, social, moral, and creative life of its clients via a
                                            free but quality tertiary education;
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="1">
                                            <v-icon small>mdi-circle</v-icon>
                                        </v-col>
                                        <v-col>
                                            Provide the clients with rich and substantial, relevant and wide range of academic disciplines,
                                            exposed them to varied curricular experiences with nurture and enhance their personal dedication
                                            and commitments to social, moral, cultural, and economic transformations;
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="1">
                                            <v-icon small>mdi-circle</v-icon>
                                        </v-col>
                                        <v-col>
                                            Work with the government and community in the pursuit of achieving national development goals, and,
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="1">
                                            <v-icon small>mdi-circle</v-icon>
                                        </v-col>
                                        <v-col>
                                            Develop deserving and qualified clients into the different skills of life existence and prepare them to 
                                            local and global competitiveness.
                                        </v-col>
                                    </v-row>
                               </v-card-text>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>

            <template>
                <v-dialog v-model="dialogComment" max-height="400px"  max-width="500px" scrollable class="dialog-container">
                    <v-card>
                        <v-card-title style="background-color:#404040 ;color:#c5aa6a" class="justify-center">
                            <b>{{ commentSectionTitle.toUpperCase() }}</b>
                        </v-card-title>
                        <v-card-subtitle style="background-color:#404040 ;color:white" class="text-center">
                            {{ commentSectionDescription }}
                        </v-card-subtitle>
                        <v-card-text style="height: 400px;" v-if="initializing == true">
                            <h1 class="text-center" style="color:rgb(202, 198, 198); margin-top: 50%; transform: translateY(-50%);">
                                LOADING...
                            </h1>
                        </v-card-text>
                        <v-card-text  style="height: 400px;" v-else-if="commentList.length == 0">
                            <h1 class="text-center" style="color:rgb(202, 198, 198); margin-top: 50%; transform: translateY(-50%);">
                                NO COMMENTS YET!
                            </h1>
                        </v-card-text>
                        <v-card-text style="height: 400px;" v-else>
                            <v-list three-line>
                                <v-list-item-group>
                                    <template v-for="(items, index) in commentList">
                                        <v-divider v-if="index > 0" :key="`${index}-divider`"></v-divider>
                                        <v-list-item :key="index">
                                            <v-list-item-avatar>
                                                <v-img v-if="items.ImageName == 'blank.png'" src="storage/UploadImage/blank.png"></v-img>
                                                <v-img v-else :src="'storage/UploadImage/' + items.AlumniID + '/' + items.ImageName"></v-img>
                                            </v-list-item-avatar>
                                            <v-list-item-content class="px-0">
                                                <v-list-item-title>
                                                    <v-row no-gutters>
                                                        <v-col cols="8">
                                                            <b :style="cName == items.FirstName + ' ' + items.LastName ? 'color:#4379F2' : 'color:#c5aa6a'">{{ items.FirstName + ' ' + items.LastName }}</b>
                                                            <h6 style="color: rgb(124, 121, 121)">{{ moment(items.CreatedDate).fromNow() }}</h6>
                                                        </v-col>
                                                    </v-row>
                                                </v-list-item-title>
                                                
                                                <v-card-text class="py-0" v-if="commentIndex == index">
                                                    <v-textarea
                                                        @keydown.enter.prevent="insertEditComment($event)"
                                                        autofocus
                                                        hide-details
                                                        @blur="lostFocus()"
                                                        dense
                                                        outlined
                                                        v-model="objComments.Details"
                                                        append-icon="mdi-arrow-right"
                                                        auto-grow
                                                        solo
                                                        rows="1" 
                                                        row-height="15"
                                                    />
                                                </v-card-text>
                                                <v-card-text class="py-0" v-else-if="loadComment[index]">
                                                    <v-row align="center" justify="center">
                                                        <b style="color:rgb(124, 121, 121)">LOADING...</b>
                                                    </v-row>
                                                </v-card-text>
                                                <v-card-text class="py-0" v-else>
                                                    {{ items.Details }}
                                                </v-card-text>
                                            </v-list-item-content>
                                            <v-list-item-action >
                                                <v-list-item-action-text >
                                                    {{items.isEdited == 1 ? 'Edited' : '' }}
                                                    <v-menu bottom left v-if="cName == items.FirstName + ' ' + items.LastName">
                                                        <template v-slot:activator="{on, attrs}">
                                                            <v-btn
                                                                v-on="on"
                                                                v-bind="attrs"
                                                                icon
                                                            >
                                                                <v-icon>mdi-dots-vertical</v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <v-list>
                                                            <v-list-item @click="editComment(items,index)">EDIT</v-list-item>
                                                            <v-list-item @click="deleteComment(items,index)">DELETE</v-list-item>
                                                        </v-list>
                                                    </v-menu>
                                                </v-list-item-action-text>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </template>
                                </v-list-item-group>
                            </v-list>
                        </v-card-text>
                        <v-divider/>
                        <v-card-actions>
                            <v-textarea
                                hide-details 
                                v-model="newComment"
                                @keydown.enter.prevent="insertNewComment($event)"
                                append-icon="mdi-arrow-right"
                                outlined 
                                auto-grow
                                solo
                                label="Add comment"
                                hint="Click ENTER to submit"
                                dense 
                                rows="1" 
                                row-height="15"
                            />
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </template>


            


            <template>
                <v-dialog v-model="UploadDialog" max-width="500px" persistent>
                    <v-card >
                        <v-card-title  style="background-color:#404040 ;color:white" >UPLOAD NEW FILE
                            <v-spacer/>
                            <span  class="cursor" @click="UploadDialog = false" >❌</span>
                        </v-card-title>
                       <v-container class="pb-0">
                            <v-row no-gutters>
                                <v-col cols="12" sm="8" md="6">
                                    <v-file-input
                                        v-model="filename"
                                        :rules="UploadRules"
                                        accept=".pdf"
                                        prepend-icon="mdi-paperclip"
                                        chips
                                        small-chips
                                        outlined
                                        dense
                                        label="Upload file here"
                                    ></v-file-input>
                                </v-col>
                            </v-row>

                            <v-row no-gutters>
                                <v-col cols="12" >
                                    <v-textarea
                                        v-model="file_text"
                                        auto-grow
                                        outlined
                                        name="input-7-4"
                                        label="Put descripton here"
                                    ></v-textarea>
                                </v-col>
                            </v-row>
                       </v-container>

                       <v-card-actions class="pt-0">
                            <v-spacer></v-spacer>
                            <v-btn
                                @click="mUpload()"
                                :disabled="(filename && file_text) ? false : true" 
                            >Save</v-btn>
                       </v-card-actions>
                    </v-card>
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


        </v-container>
    </v-layout>

</template>
<script>
import Swal from 'sweetalert2'
import moment from 'moment';
export default {
    data: () => ({
        pageNumber: 1,
        showEditDeleteComment: false,
        boolEditComment: false,
        commentIndex: null,
        objComments: {},
        loadComment: [],
        moment: moment,
        commentList: [],
        search: '',
        initializing: false,
        AlumniID: '',
        newComment: '',
        overlay:  false,
        dialogComment: false,
        commentSectionTitle: '',
        commentSectionDescription: '',
        commentTime: '',
        filename: [],
        topicList: [],
        topicID: '',
        file_text: '',
        UploadRules:[
            value => !value || value.size < 2000000 || 'File size should be less than 2 MB!'
        ],
        UploadDialog: false,
        PDFfiles:[],
        existPDF: [],
        insertedComments: {},
        // colors: [
        //     {color:'#A1D6B2', text:'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem enim voluptatibus tempora sapiente corrupti ipsam reiciendis deserunt nulla unde vel praesentium dicta, libero ut commodi mollitia quas quos error provident?'},
        //     {color:'#CEDF9F', text:'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Esse ipsum dolor placeat a distinctio autem dolorem repellendus saepe neque similique voluptate omnis, soluta fugiat iste veniam laudantium dicta quidem unde.'},
        //     {color:'#F1F3C2', text:'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, fugiat. Quam temporibus sequi dolorum at magni corrupti eligendi quas nemo rem tempora perferendis, veritatis doloremque odio quaerat voluptas, delectus praesentium.'},
        //     {color:'#E8B86D', text:'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolor beatae itaque saepe cupiditate consequatur error tempora consectetur ipsum ratione ullam, ut totam mollitia sapiente nihil quasi debitis nulla cumque maxime.'},
        // ],

        images:[
            {path:'images/Covers/image1.jpeg'},
            {path:'images/Covers/image2.jpeg'},
            {path:'images/Covers/image3.jpg'},
            {path:'images/Covers/image4.png'},
        ]
    }),
    
    created() {
        this.mgetPDfList()
    },

    watch: {
        commentList: {
            handler(newList) {
                // Ensure that the editingIndex is still valid after list changes
                if (this.editingIndex !== null && this.editingIndex >= newList.length) {
                    this.editingIndex = null;
                }
            },
            deep: true
            }
    },

    computed: {

        ctopicList(){
            const start = (this.pageNumber - 1) * 5, end = start + 5;
            return this.topicList.slice(start, end);
        },
        ctopicListpage(){
            let length = this.topicList.length
            return Math.ceil(length/5);
        },


        cName(){
            return this.$store.state.UserInfo.FirstName + ' ' + this.$store.state.UserInfo.LastName
        },

        cMyCredential(){
            return this.$store.state.UserInfo.Username != undefined;
        },

        
        mValidateUpload() {
            return () => {
                const PDFName = this.filename.name;
                return axios.get(`/api/pdflist?PDFName=${PDFName}&REQUEST=WITH_PARAM`)
                    .then((res) => {
                        if (res.data.length !== 0) {
                            this.existPDF = res.data;
                        }
                    });
            };
        },

        computedHeaders(){
            const headers=[
                {text:'Memo ID', value: 'PdfID', align: 'center'},
                {text:'Description', value: 'Description', align: 'center'},
                {text:'Year', value: 'CreatedDate', align: 'center'},
                {text:'View', value: 'view', align: 'center'},
                {text:'Action', value: 'action', user: "Admin", align: 'center'},
            ]

            if(this.$store.state.UserInfo.UserType != 'Admin' ){
                headers.pop();
            }

            return headers
        },

        MyCredential(){
            return this.$store.state.UserInfo.UserType == 'Admin';
        }
    },

    watch: {
        
    },


    methods: {

        lostFocus(){
            this.boolEditComment = false
            this.commentIndex = null
        },

        editComment(data, i){
            this.boolEditComment = true
            this.loadComment[i] = true
            // this.loadComment[i] = false
            this.commentIndex = i
            this.objComments.Details = data.Details
            this.objComments.AlumniID = data.AlumniID
            this.objComments.CommentID = data.CommentID

        },

        deleteComment(data, i){
            axios.post(`api/comment?method=DELETE&&CommentID=${data.CommentID}&&ID=${data.AlumniID}`)
            .then((res) =>{
                this.getComment()
            })
        },

        insertEditComment(e){
            this.lostFocus()
            if(this.objComments.Details){
                axios.post(`api/comment?method=EDIT`, this.objComments)
                .then((res) =>{
                    if(res.data == 'success'){
                        this.getComment()
                    }
                })
            }
        },


        insertNewComment(event){
            if(this.newComment){
                if(event.code == 'Enter' || event.code == 'NumpadEnter'){
                    axios.post(`api/comment?method=INSERT&&ForumID=${this.topicID}&&NewComment=${this.newComment}&&AlumniID=${this.AlumniID}`)
                    .then((res) =>{
                        this.newComment = ''
                        if(res.data == 'success'){
                            this.getComment()
                        }
                    })
                }
            }
        },

        showCommentSection(item){
            this.newComment = ''
            this.initializing = true
            this.commentList = []
            this.dialogComment = true
            this.commentSectionDescription = item.Description
            this.commentSectionTitle = item.Title
            this.topicID = item.ForumID
            this.AlumniID = this.$store.state.UserInfo.AlumniID,
            this.getComment()
        },

        getComment(){
            axios.get(`api/comment/show?method=GET_COMMENT&&ID=${this.topicID}`)
            .then((res) =>{
                this.overlay = false
                this.commentList = res.data
                this.initializing = false
                this.objComments = {}
                this.loadComment = {}
                this.countCommentandTopic()
            })
        },

        // getTopics(){
        //     axios.get(`api/forum?method=GET`)
        //     .then((res) =>{
        //         this.overlay = false
        //         this.topicList = res.data
        //         this.countComment()
        //     })
        // },

        countCommentandTopic(){
            axios.get(`api/comment/show?method=COUNT_TOPICCOMMENT`)
            .then((res) =>{
                this.overlay = false
                this.topicList = res.data
            })
        },
        
        mUpload() {
            this.overlay = true
            this.UploadDialog = false;
            const formData = new FormData();
            formData.append('file', this.filename);
            formData.append('description', this.file_text);
            let data = {
                filename: this.filename.name,
                text: this.file_text
            };
            this.mValidateUpload().then(() => {
                if (this.existPDF.length > 0) {
                    this.mconfirmationUploadDialog(data);
                } else {
                    axios({
                        method: "POST",
                        url: `api/upload`,
                        data: formData
                    }).then((res) => {
                        this.filename = [];
                        this.file_text = '';
                        if (res.data === 'Success') {
                            this.minsertPDF(data)
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'There was an error in uploading',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 2000
                            });
                        }
                    }).catch((error) => {
                        console.error('Upload error:', error);
                        this.filename = [];
                        this.file_text = '';
                        this.overlay = false
                        this.UploadDialog = false;
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred during file upload',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 2000
                        });
                    });
                }
            });
        },

        minsertPDF(data){
            axios.post('api/pdflist',data).then((res) => {
                if (res.data === 'Success') {
                    Swal.fire({
                        title: 'Success',
                        text: 'PDF uploaded successfully!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {});
                } else {
                    this.filename = [];
                    this.file_text = '';
                    Swal.fire({
                        title: 'Success',
                        text: 'Your file has been reuploaded successfully!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }).then(()=>{
                this.overlay = true
                this.mgetPDfList();
            });
            
        },
        mgetPDfList(){
            this.overlay = true
            axios.get('api/pdflist').then((res)=>{
                this.PDFfiles = res.data
                this.countCommentandTopic()
                
            })
        },

        mconfirmationUploadDialog(data){
            Swal.fire({
                title: "File exist!",
                text: "You want to replace it?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes"
                }).then((result) => {
                if (result.isConfirmed) {
                    this.minsertPDF(data)
                }else{
                    this.overlay = false
                }
            });
        },


        mconfirmationDeleteDialog(data){
            Swal.fire({
                title: "Are you sure you want to delete it?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                }).then((result) => {
                if (result.isConfirmed) {
                    this.DeletePDF(data.PdfID)
                }
            });
        },


        DeletePDF(item){
            this.overlay = true
            axios.put(`api/pdflist/update?data=${item}`)
            .then((res)=>{
                Swal.fire({
                    title: 'Success',
                    text: 'File has been deleted successfully!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                }).then(()=>{
                    this.mgetPDfList()
                })
            })
        }
        
    },
}
</script>

<style>
.card-text{
    font-weight:1000; 
    font-size:24px;
    font-family: cursive;
}

.right-aligned {
  text-align: right !important;
}

.subtitle_item{
    line-height: 10 !important; 
    min-height: 120px !important;
}


.dialog-container {
    overflow-y: hidden !important;
}

.v-data-table tbody td{
    align-items: center;
}

</style>