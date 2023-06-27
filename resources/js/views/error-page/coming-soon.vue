<template>
  <el-row :gutter="40" class="coming-soon-container">
    <el-col :xs="24" :sm="24" :md="12" :lg="12" class="m-auto">
    <el-button :icon="ArrowLeft" class="pan-back-btn" @click="back">{{ langTitle('back') }}</el-button>
        <h1 class="text-jumbo text-ginormous">{{ langTitle('coming_soon') }}</h1>
    </el-col>
    <el-col :xs="24" :sm="24" :md="12" :lg="12">
        <img :src="errGif" width="313" height="428" alt="Girl has dropped her ice cream." />
    </el-col>
    <el-dialog v-model="dialogVisible" title="Let's see">
      <img :src="ewizardClap" class="pan-img" />
    </el-dialog>
  </el-row>
</template>

<script setup>
import { reactive, toRefs } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import errGif from '@/assets/401_images/401.gif'
import { ArrowLeft } from '@element-plus/icons-vue'
import { langTitle } from '@/hooks/use-common'

const state = reactive({
  errGif: `${errGif  }?${ Date.now()}`,
  ewizardClap: 'https://wpimg.wallstcn.com/007ef517-bafd-4066-aae4-6883632d9646',
  dialogVisible: false
})

const route = useRoute()
const router = useRouter()
const back = () => {
  if (route.query.noGoBack) {
    router.push({ path: '/dashboard' })
  } else {
    router.go(-1)
  }
}
//导出属性到页面中使用
const { ewizardClap, dialogVisible } = toRefs(state)
</script>

<style lang="scss" scoped>
.coming-soon-container {
  text-align: center;
  .pan-back-btn {
    background: #008489;
    color: #fff;
    border: none !important;
  }
  .pan-gif {
    margin: 0 auto;
    display: block;
  }
  .pan-img {
    display: block;
    margin: 0 auto;
    width: 100%;
  }
  .text-jumbo {
    font-size: 60px;
    font-weight: 700;
    color: #484848;
    margin-bottom: 20px;
  }
  .list-unstyled {
    font-size: 14px;
    li {
      padding-bottom: 5px;
    }
    a {
      color: #008489;
      text-decoration: none;
      &:hover {
        text-decoration: underline;
      }
    }
  }
}
</style>
