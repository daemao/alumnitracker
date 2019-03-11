<style scoped>
    .main{
        display: flex;
        flex-direction: column;
        justify-content: stretch;
        height: 100%;
        margin-right: 5vh;
        margin-left: 5vh;
    }
    .topper{
        height: 30vh;
        background-image: linear-gradient(#a769b7, #482f63);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
    }
    .bottom{
        height: 70%;
        background-color: #e7e3e5;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        background-attachment: local;
    }
    .left{
        position: relative;
        top: -20vh;
        background: white;
        width: 25%;
        height: 100vh;
    }
    .right{
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 65%;
        margin-top: 3vh;
        margin_bottom: 3vh;
    }
    .avatar{
        display: flex;
        flex-direction: column;
        align-items: center;
        max-height: 70vh;
    }
    .upload_button{
        position: relative;
        top: -55px;
        text-align: center;
        font-weight:bold;
        font-size: 30px;
        font-family: cursive;
        background: white;
        width:70%;
        border-radius: 20px;
        z-index: 1000;
    }
    .upload_button:hover{
        border: 3px solid white;
        background: #d2afd3;
        font-color: white;
    }
    .name{
        font-size: 50px;
        text-align: center;
        font-family: monospace;
        color: white;
    }
    .name1{
        color: white;
        font-size: 30px;
        text-align: center;
        font-family: monospace;
    }
    .carousel{
        height: 25vh;
        width: 80vh;
        background:white;
    }
    .carousel_component{
        max-width: 25vh;
        max-height: 25vh;
        width: 20vh;
        height: 20vh;
    }
    .news{
        background: white;
        width: 80vh;
        font-size: 20px;
    }
    .news p1{
        font-style: italic;
    }
    .info{
        font-size: 20px;
        text-align: center;
        font-weight: bold;
    }
</style>
<template>
    <div class="base" v-if="$root && $root.user && $root.user.data && $root.user.data.id">
        <div class="main">
            <div class="topper">
                <h1 class="name">{{user.first_name}} {{user.last_name}}</h1>
                <h2 class="name1">Current city (status)</h2>
            </div>
            <div class="bottom">
                <div class="left">
                    <div class="avatar">
                        <template v-if="user.avatar">
                            <img :src="'/storage/'+user.avatar.url" alt="there is an image" class="avatar" >
                        </template>
                        <template v-else>
                            <img src='/storage/noimage.png' class="avatar">
                        </template>
                        <input type="file" accept="image/png, image/jpeg" @change="sendFile" ref="upload_image_button" hidden />
                        <div class="upload_button" @click="$refs.upload_image_button.click()">Upload image</div>
                    </div>
                    <div class="info">
                        <p>Followers:</p>
                        <p>Following:</p>
                    </div>
                </div>
                <div class="right">
                    <div v-if="user.photos && user.photos.length>3" class="carousel">
                        <b-carousel
                            id="carousel1"
                            style="text-shadow: 1px 1px 2px #333;"
                            controls
                            indicators
                            background="#ababab"
                            :interval="4000"
                            img-width="1024"
                            img-height="480"
                            v-model="slide"
                            @sliding-start="onSlideStart"
                            @sliding-end="onSlideEnd"
                        >
                            <b-carousel-slide
                                :img-src="'/storage/'+user.photos[0].url"
                                class="carousel_component"
                            />
                            <b-carousel-slide :img-src="'/storage/'+user.photos[1].url" class="carousel_component"/>
                            <b-carousel-slide :img-src="'/storage/'+user.photos[2].url" class="carousel_component"/>
                        </b-carousel>
                    </div>
                    <div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                        <div class="news">
                            <p1>Day/Month/Year</p1>
                            <p>News</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {get,post} from "../../api";
    export default {
        props:["id"],
        data(){
            return {
                user:"",
                loading:true,
                slide: 0,
                sliding: null
            }
        },
        methods:{
            getItem(){
                let _this=this;
                get(_this,"/api/alumni/"+this.id,{},
                    (res)=>{
                        _this.user=res.data;
                    },
                    (err)=>{}
                );
            },
            sendFile(e){
                let _this=this;
                let formData = new FormData();
                formData.append('photo', e.target.files[0]);
                formData.append("id",_this.user.id);
                post(_this,"/api/update-user-photo",formData ,
                    (res)=>{
                        _this.user = res.data;
                    },
                    (err)=>{

                    })
            },
            onSlideStart(slide) {
                this.sliding = true
            },
            onSlideEnd(slide) {
                this.sliding = false
            }
        },
        created(){
            this.getItem();
        }
    }
</script>

