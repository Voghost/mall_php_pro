<template>
  <div class="login-register">
    <!--   腾讯防水墙 -->
    <div class="contain">
      <div class="big-box" :class="{active:isLogin}">
        <div class="big-contain" v-if="isLogin">
          <div class="btitle">账户登录</div>
          <div class="bform">
            <el-input
                placeholder="请输入用户名"
                v-model="form.username"
                clearable>
            </el-input>
            <span class="errTips" v-if="userError">* 用户填写错误 *</span>
            <el-input placeholder="请输入密码" v-model="form.userpwd" show-password></el-input>
            <span class="errTips" v-if="passwordError">* 密码填写错误 *</span>
          </div>
          <button class="bbutton" @click="login" id="TencentCaptcha" data-appid="appId" data-cbfn="callback">登录</button>
        </div>
        <div class="big-contain" v-else>
          <div class="btitle">创建账户</div>
          <div class="bform">
            <el-input
                placeholder="请输入用户名"
                v-model="form.username"
                clearable>
            </el-input>
            <span class="errTips" v-if="existed">* 用户名已经存在！ *</span>
            <el-input placeholder="请输入密码" v-model="form.userpwd" show-password></el-input>
            <el-input placeholder="请再次输入密码" v-model="form.userrepwd" show-password></el-input>
          </div>
          <button class="bbutton" @click="register">注册</button>
        </div>
      </div>
      <div class="small-box" :class="{active:isLogin}">
        <div class="small-contain" v-if="isLogin">
          <div class="stitle">你好，朋友!</div>
          <p class="scontent">开始注册，和我们一起购物</p>
          <button class="sbutton" @click="changeType">注册</button>
        </div>
        <div class="small-contain" v-else>
          <div class="stitle">欢迎回来!</div>
          <p class="scontent">与我们一起购物，请登录你的账户</p>
          <button class="sbutton" @click="changeType">登录</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'login_register',
  data() {
    return {
      isLogin: true,
      userError: false,
      passwordError: false,
      existed: false,
      form: {
        username: '',
        userrepwd: '',
        userpwd: ''
      }
    }
  },
  methods: {
    changeType() {
      this.isLogin = !this.isLogin
      this.form.username = ''
      this.form.userpwd = ''
      this.form.userrepwd = ''
    },
    login() {
      const self = this;
      if (self.form.username != "" && self.form.userpwd != "") {
        self.$axios({
          method: 'post',
          url: 'http://127.0.0.1:10520/api/user/login',
          data: {
            username: self.form.username,
            password: self.form.userpwd
          }
        })
            .then(res => {
              switch (res.data) {
                case 0:
                  alert("登陆成功！");
                  break;
                case -1:
                  this.userError = true;
                  break;
                case 1:
                  this.passwordError = true;
                  break;
              }
            })
            .catch(err => {
              console.log(err);
            })
      } else {
        alert("填写不能为空！");
      }
    },
    register() {
      const self = this;
      if (self.form.username != "" && self.form.userpwd == self.form.userrepwd) {
        self.$axios({
          method: 'post',
          url: 'http://127.0.0.1:10520/api/user/add',
          data: {
            username: self.form.username,
            password: self.form.userpwd
          }
        })
            .then(res => {
              switch (res.data) {
                case 0:
                  alert("注册成功！");
                  this.login();
                  break;
                case -1:
                  this.existed = true;
                  break;
              }
            })
            .catch(err => {
              console.log(err);
            })
      } else if (self.form.username != "" && self.form.userpwd != self.form.userrepwd) {
        alert("两次密码输入不相同！");
      } else {
        alert("填写不能为空");
      }
    }
  }
}
</script>

<style scoped="scoped">
.login-register {
  width: 100vw;
  height: 100vh;
  box-sizing: border-box;
}

.contain {
  width: 60%;
  height: 60%;
  position: relative;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  border-radius: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04)
}

.big-box {
  width: 70%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 30%;
  transform: translateX(0%);
  transition: all 1s;
}

.big-contain {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.btitle {
  font-size: 1.5em;
  font-weight: bold;
  color: rgb(57, 167, 176);
}

.bform {
  width: 90%;
  height: 40%;
  padding: 2em 0;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  align-items: center;
  max-width: 400px;
  margin: 0 auto;
}

.bform .errTips {
  display: block;
  width: 50%;
  text-align: left;
  color: red;
  font-size: 0.7em;
  margin-left: 1em;
}

.bform input {
  width: 50%;
  height: 30px;
  border: none;
  outline: none;
  border-radius: 10px;
  padding-left: 2em;
  background-color: #f0f0f0;
}

.bbutton {
  width: 20%;
  height: 40px;
  border-radius: 24px;
  border: none;
  outline: none;
  background-color: rgb(57, 167, 176);
  color: #fff;
  font-size: 0.9em;
  cursor: pointer;
}

.small-box {
  width: 30%;
  height: 100%;
  background: linear-gradient(135deg, rgb(57, 167, 176), rgb(56, 183, 145));
  position: absolute;
  top: 0;
  left: 0;
  transform: translateX(0%);
  transition: all 1s;
  border-top-left-radius: inherit;
  border-bottom-left-radius: inherit;
}

.small-contain {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.stitle {
  font-size: 1.5em;
  font-weight: bold;
  color: #fff;
}

.scontent {
  font-size: 0.8em;
  color: #fff;
  text-align: center;
  padding: 2em 4em;
  line-height: 1.7em;
}

.sbutton {
  width: 60%;
  height: 40px;
  border-radius: 24px;
  border: 1px solid #fff;
  outline: none;
  background-color: transparent;
  color: #fff;
  font-size: 0.9em;
  cursor: pointer;
}

.big-box.active {
  left: 0;
  transition: all 0.5s;
}

.small-box.active {
  left: 100%;
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
  border-top-right-radius: inherit;
  border-bottom-right-radius: inherit;
  transform: translateX(-100%);
  transition: all 1s;
}
</style>
