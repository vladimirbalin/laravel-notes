import Login from "./Login";
import Register from "./Register";
import Home from "./Home";

export default [
    {path: '/login', component: Login, name: 'login'},
    {path: '/register', component: Register, name: 'register'},
    {path: '/', component: Home, name: 'home'},
]
