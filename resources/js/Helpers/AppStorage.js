class AppStorage{

    storeToken(token){
        localStorage.setItem('token',token)
    }
    storeUser(user){
        localStorage.setItem('user',user)
    }

    store(token,user){
        this.storeToken(token);
        this.storeUser(user);
    }

    clear(){
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    }
    clearCard(){
        localStorage.removeItem('cart_id');
    }
    storeCartId(cart_id) {
        localStorage.setItem('cart_id', cart_id);
    }
    getToken(){
        localStorage.getItem('token');
    }

    getUser(){
        localStorage.getUser('user')
    }
    getCartId() {
        return localStorage.getItem('cart_id');
    }
}

export default AppStorage=new AppStorage();