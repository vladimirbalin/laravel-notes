<template>
    <div class="form-wrapper">
        <h3>Register and create notes</h3>
        <form @submit.prevent="register" action="">
            <div v-if="errors" class="errors">
                <p v-for="(error, field) in errors" :key="field">
                    {{ error }}
                </p>
            </div>
            <input type="text" v-model="form.username" placeholder="Your username"><br>
            <input type="text" v-model="form.email" placeholder="Your email"><br>
            <input type="password" v-model="form.password" placeholder="Your password"><br>
            <input type="password" v-model="form.password_confirmation" placeholder="Repeat password"><br>
            <button @click="register">Register</button>
            <router-link to="/login" class="link">Click here to login</router-link>
        </form>
    </div>
</template>

<script>
import httpService from "../services/http.service";

export default {
    name: "Register",
    data() {
        return {
            form: {
                username: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: null
        }
    },
    methods: {
        async register(e) {
            e.preventDefault();

            try {
                const {data, status} = await httpService.post('register', this.form);
                if (status === 200) {
                    this.$router.push({name: 'login'});
                }
            } catch (err) {
                this.errors = err.response.data.errors;
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.form-wrapper {
    background-color: white;
    padding: 20px;
    width: 300px;
    margin: 0 auto;
    border-radius: 4px;
    box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);

    h3 {
        text-align: center;
        margin-bottom: 30px;
    }
}

form {
    input {
        display: block;
        width: 100%;
        border: 2px solid #e6e6e6;
        padding: 6px 12px;
        transition: all 0.3s;

        &:focus {
            outline: 0;
            border-color: #4fb2c1;
        }
    }

    button {
        outline: 0;
        cursor: pointer;
        border: 1px solid darken(#4fb2c1, 5%);
        background-color: #4fb2c1;
        color: white;
        padding: 6px 12px;
        transition: all 0.3s;

        &:hover {
            background-color: darken(#4fb2c1, 10%);
        }
    }

    .errors {
        margin-bottom: 15px;
        padding: 10px 15px;
        color: #fff;
        background-color: #ff6969;
        font-size: 12px;

        p {
            margin: 0;
        }
    }

    .link {
        font-size: 80%;
        float: right;
    }
}
</style>
