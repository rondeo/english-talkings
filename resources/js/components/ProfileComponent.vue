<template>
    <div>
        <div class="row">
            <div class="col-sm-3 form-group">
                <label for="nickname">Nickname</label>
                <input v-model="userData.nickname" type="text" id="nickname" class="form-control">
            </div>
            <div class="col-sm-3 form-group">
                <label for="sex">Sex</label>
                <select v-model="userData.sex" id="sex" class="form-control">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="col-sm-3 form-group">
                <label for="age">Age</label>
                <input v-model="userData.age" type="number" min="3" max="120" id="age" class="form-control">
            </div>
            <div class="col-sm-3 form-group">
                <label for="country">Country</label>
                <v-select id="country" v-model="userData.country" label="name" :options="countries"></v-select>
            </div>
            <div class="col-sm-3 form-group">
                <label for="talking">Language for talking</label>
                <v-select id="talking" v-model="userData.language" label="name" :options="languages"></v-select>
            </div>
            <div class="col-sm-3 form-group">
                <label for="level">Language level</label>
                <select v-model="userData.language_level_id" id="level" class="form-control">
                    <option v-for="lvl in languageLevels" :value="lvl.id">{{lvl.name | capitalize }}</option>
                </select>
            </div>
            <div class="col-sm-3 form-group">
                <label for="goal">Goal</label>
                <input v-model="userData.goal" id="goal" type="text" class="form-control">
            </div>
            <div class="col-sm-3 form-group">
                <label for="skype">Skype</label>
                <input v-model="userData.skype" id="skype" type="text" class="form-control">
            </div>
            <!--<div class="col-sm-3 form-group">
                <label for="whatsapp">Whatsapp</label>
                <input id="whatsapp" type="text" class="form-control">
            </div>
            <div class="col-sm-3 form-group">
                <label for="telegram">Telegram</label>
                <input id="telegram" type="text" class="form-control">
            </div>
            <div class="col-sm-3 form-group">
                <label for="viber">Viber</label>
                <input id="viber" type="text" class="form-control">
            </div>-->
        </div>
        <div class="col-sm-4 offset-sm-4 form-group text-center">
            <button class="btn btn-lg btn-danger btn-block" @click="save">Save</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                userData: {
                    name: '',
                    nickname: '',
                    sex: '',
                    age: '',
                    country: '',
                    language: '',
                    language_level_id: '',
                    goal: '',
                    skype: ''
                },
                countries: [],
                languages: [],
                languageLevels: [],
            }
        },
        mounted() {
            this.getCountries();
            this.getLanguages();
            this.getLanguageLevels();

            this.user = JSON.parse(this.user);
            this.userData.nickname = this.user.nickname;
            this.userData.age = this.user.age;
            this.userData.name = this.user.name;
            this.userData.sex = this.user.sex;
            this.userData.country = this.user.country;
            this.userData.language = this.user.language;
            this.userData.language_level_id = this.user.language_level_id;
            this.userData.goal = this.user.goal;
            this.userData.skype = this.user.skype;

        },
        methods: {
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
            save() {
                axios.post('/new-user', {
                    nickname: this.userData.nickname,
                    age: this.userData.age,
                    sex: this.userData.sex,
                    country: this.userData.country.id,
                    talking: this.userData.language.id,
                    level: this.userData.language_level_id,
                    goal: this.userData.goal,
                    skype: this.userData.skype,
                }).then(() => {
                    window.location.reload();
                });
            }
        },
        filters: {
            capitalize: function (value) {
                if (!value) return '';
                value = value.toString();
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },
    }
</script>
