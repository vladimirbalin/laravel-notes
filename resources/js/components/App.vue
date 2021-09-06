<template>
    <div id="app">
        <div id="nav">
            <router-link to="/login">Login</router-link>
            <router-link to="/register">Register</router-link>
            <router-link to="/">Home</router-link>
            <router-view/>
        </div>
    </div>
</template>

<style lang="scss">
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

html, body,
#app {
    height: 100%;
}

@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
#app {
    font-family: 'Roboto', sans-serif;
    background-color: #ececec;
}
</style>

<script>
</script>
