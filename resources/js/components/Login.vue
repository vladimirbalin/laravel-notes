<template>
    <div class="form-wrapper">
        <h3>Login to create notes</h3>
        <form @submit.prevent="login" action="">
            <small>please use <b>test/12345678 </b>as username/password for testing on existing notes</small><br><br>
            <div v-if="errors" class="errors">
                <p v-for="(error, field) in errors" :key="field">
                    {{ error[0] }}
                </p>
            </div>
            <input type="text" v-model="form.username" placeholder="Your username"><br>
            <div class="invalid-feedback">

            </div>
            <input type="password" v-model="form.password" placeholder="Your password"><br>
            <button>Login</button>
        </form>
    </div>
</template>

<script>

export default {
    name: "Login",
    data() {
        return {
            form: {
                username: '',
                password: ''
            },
            errors: null,
        }
    },
    methods: {
        login() {

            localStorage.setItem('api-token', data.token);

        }
    }
}
</script>

<style scoped>

</style>
