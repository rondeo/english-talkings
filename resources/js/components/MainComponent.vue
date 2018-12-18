<template>
    <div class="mt-3">
        <div class="card mb-3">
            <h5 class="card-header">Fact of the day</h5>
            <div class="card-body">
                <h5 class="card-title">{{this.fact.title}}</h5>
            </div>
        </div>

        <div class="card mb-3">
            <h5 class="card-header">Useful Videos</h5>
            <div class="card-body row">
                <div class="video-item col-sm-4" v-for="video in this.videos">
                    <h5 class="card-title">{{video.title}}</h5>
                    <iframe width="300"
                            height="220"
                            :src="'https://www.youtube.com/embed/' + video.url"
                            frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <h1 class="heading mb-3">Start search</h1>
        <div class="col-sm-4 offset-sm-4 form-group text-center">
            <button class="btn btn-lg btn-danger btn-block" @click="addNewcomer">Go</button>
        </div>

        <v-client-table v-if="showTable" :data="tableData" :columns="columns" :options="options">
            <a slot="skype" slot-scope="props" :href="'skype:'+props.row.skype">
                <img class="skype-icon" src="/png/skype-icon.png" alt="">
            </a>
            <img slot="country_id" slot-scope="props" class="skype-icon" :src="props.row.country_id" alt="" />
        </v-client-table>
    </div>
</template>

<script>
    export default {
        computed: {
            channel() {
                window.Echo.join('online-users')
            }
        },
        data() {
            return {
                columns: ['nickname', 'sex', 'age', 'country_id', 'language_id', 'language_level_id', 'goal', 'skype'],
                tableData: [
                    {
                        nickname: 'Michael',
                        age: 21,
                        sex: 'male',
                        country_id: 'svg/flags/United Kingdom of Great Britain and Northern Ireland.svg',
                        skype: 'asdasd',
                        language_id: 'English',
                        goal: 'I can help you to improve English',
                        language_level_id: 'Fluent',
                    },
                    {
                        nickname: 'Aisha',
                        age: 20,
                        sex: 'female',
                        country_id: 'svg/flags/Argentina.svg',
                        skype: 'asdasd',
                        language_id: 'English',
                        goal: "I'm looking for an English teacher here",
                        language_level_id: 'Upper-intermediate',
                    },
                    {
                        nickname: 'Tanya',
                        age: 25,
                        sex: 'female',
                        country_id: 'svg/flags/Russian Federation.svg',
                        skype: 'asdasd',
                        language_id: 'English',
                        goal: "Let's talk about travelling",
                        language_level_id: 'Advanced',
                    },
                    {
                        nickname: 'guāngmíng',
                        age: 30,
                        sex: 'male',
                        country_id: 'svg/flags/China.svg',
                        skype: 'asdasd',
                        language_id: 'English',
                        goal: 'Just speaking practice',
                        language_level_id: 'Intermediate',
                    },
                    {
                        nickname: 'Lucy',
                        age: 20,
                        sex: 'female',
                        country_id: 'svg/flags/United States of America.svg',
                        skype: 'asdasd',
                        language_id: 'Spanish',
                        goal: "Is somebody speak Spanish here?",
                        language_level_id: 'Intermediate',
                    },
                    {
                        nickname: 'Andreas',
                        age: 33,
                        sex: 'male',
                        country_id: 'svg/flags/Spain.svg',
                        skype: 'asdasd',
                        language_id: 'Spanish',
                        goal: "¿qué pasa?",
                        language_level_id: 'Intermediate',
                    }
                    ],
                options: {
                    headings: {
                        country_id: 'Country',
                        language_id: 'Want to talk in',
                        language_level_id: 'Level'
                    },
                },
                user: {
                    id: '',
                    name: '',
                    nickname: '',
                    sex: '',
                    age: '',
                    country: '',
                    talking: '',
                    level: '',
                    goal: '',
                    skype: ''
                },
                countries: [],
                languages: [],
                languageLevels: [],
                fact: {},
                videos: [],
                showTable: false
            }
        },
        mounted() {
            Promise.all([
                this.getCountries(),
                this.getLanguages(),
                this.getLanguageLevels(),
                this.getFact(),
                this.getVideos(),
            ]).then(() => {
                if (window.Echo !== undefined) {
                    window.Echo.join('online-users').here((users) => {
                        this.tableData = users.filter((user) =>
                            user.country_id = this.countries[user.country_id].flag
                        );
                        this.tableData = this.tableData.filter((user) =>
                            user.language_id = this.languages[user.language_id].name
                        );
                        this.tableData = this.tableData.filter((user) =>
                            user.language_level_id = this.languageLevels[user.language_level_id].name
                        );
                    })
                        .joining((user) => {
                            user.country_id = this.countries[user.country_id].flag
                            user.language_id = this.languages[user.language_id].name
                            user.language_level_id = this.languageLevels[user.language_level_id].name

                            this.tableData.push(user)
                        })
                        .leaving((user) => (this.tableData.splice(this.tableData.indexOf(user.id), 1)))
                        .listen('online-users');

                    this.showTable = true;
                }
            });

        },
        methods: {
            addNewcomer() {
                // axios.post('/new-user', {
                //     id: this.user.id,
                //     nickname: this.user.nickname,
                //     age: this.user.age,
                //     sex: this.user.sex,
                //     country: this.user.country.id,
                //     talking: this.user.talking.id,
                //     level: this.user.level,
                //     goal: this.user.goal,
                //     skype: this.user.skype,
                // });

                //this.channel

                this.showTable = true;
            },
            getNewcomers() {
                axios.get('/newcomers')
                    .then(response => {
                        this.tableData = response.data
                    })
            },
            getCountries() {
                axios.get('/countries')
                    .then(response => {
                        this.countries = response.data
                    })
            },
            getLanguages() {
                axios.get('/languages')
                    .then(response => {
                        this.languages = response.data
                    })
            },
            getLanguageLevels() {
                axios.get('/language-levels')
                    .then(response => {
                        this.languageLevels = response.data
                    })
            },
            getFact() {
                axios.get('/fact')
                    .then(response => {
                        this.fact = response.data
                    })
            },
            getVideos() {
                axios.get('/get-last-videos')
                    .then(response => {
                        this.videos = response.data
                    })
            }
        },
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },
    }
</script>
<style>
</style>
