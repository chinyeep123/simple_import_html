
<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="24">
        <el-card shadow="never">
          <template #header>
            <el-form-item>
              <el-dropdown split-button>
                Import
                <template #dropdown>
                  <el-dropdown-menu>
                    <el-dropdown-item
                      :icon="Download"
                      @click="handleDownloadTemplate"
                      >Download Sample</el-dropdown-item
                    >
                    <el-dropdown-item :icon="Top" @click="showImportDialog"
                      >Import</el-dropdown-item
                    >
                  </el-dropdown-menu>
                </template>
              </el-dropdown>
            </el-form-item>
          </template>

          <el-table
            v-loading="loading"
            :data="productList"
            @selection-change="handleSelectionChange"
          >
            <template #header>
              <el-input v-model="search" size="small" placeholder="Type to search" />
            </template>
            <el-table-column type="selection" width="50" align="center" />
            <el-table-column
              key="id"
              label="ID"
              align="center"
              prop="id"
              width="100"
            />
            <el-table-column
              key="product_id"
              label="Product ID"
              align="center"
              prop="product_id"
            />
            <el-table-column
              key="type"
              label="Types"
              align="center"
              prop="type"
            />
            <el-table-column
              key="brand"
              label="Brand"
              align="center"
              prop="brand"
            />
            <el-table-column
              key="model"
              label="Model"
              align="center"
              prop="model"
            />
            <el-table-column
              key="capacity"
              label="Capacity"
              align="center"
              prop="capacity"
            />
            <el-table-column
              key="quantity"
              label="Quantity"
              align="center"
              prop="quantity"
            />
          </el-table>

          <pagination
            v-if="total > 0"
            :total="total"
            v-model:page="queryParams.pageNum"
            v-model:limit="queryParams.pageSize"
            @pagination="handleQuery"
          />
        </el-card>
      </el-col>
    </el-row>

    <!-- import dialog -->
    <el-dialog
      :title="importDialog.title"
      v-model="importDialog.visible"
      width="600px"
      append-to-body
      @close="closeImportDialog"
    >
      <el-form
        ref="importFormRef"
        :model="importFormData"
        :rules="rules"
        label-width="80px"
      >
        <el-form-item label="Excel">
          <el-upload
            class="upload-demo"
            action=""
            drag
            :auto-upload="false"
            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            :file-list="excelFilelist"
            :on-change="handleExcelChange"
            :limit="1"
          >
            <el-icon class="el-icon--upload">
              <upload-filled />
            </el-icon>
            <div class="el-upload__text">
              Drop your file here or
              <em>click to upload</em>
            </div>
            <template #tip>
              <div class="el-upload__tip">xls/xlsx files</div>
            </template>
          </el-upload>
        </el-form-item>
      </el-form>
      <template #footer>
        <div class="dialog-footer">
          <el-button type="primary" @click="submitImportForm">Confirm</el-button>
          <el-button @click="closeImportDialog">Cancel</el-button>
        </div>
      </template>
    </el-dialog>
  </div>
</template>


<script setup lang="ts">
import {
  reactive,
  ref,
  watchEffect,
  onMounted,
  getCurrentInstance,
  toRefs,
  computed
} from 'vue';

// api
import {
  listProducts,
  importProducts,
  downloadTemplate
} from '@/api/product'

import {
  ElTree,
  ElForm,
  ElMessageBox,
  ElMessage,
  UploadFile
} from 'element-plus';
import {
  Plus,
  Refresh,
  Delete,
  Download,
  Top,
  UploadFilled
} from '@element-plus/icons-vue';

import Pagination from '@/components/Pagination/index.vue';

const queryFormRef = ref(ElForm); 
const dataFormRef = ref(ElForm); 
const importFormRef = ref(ElForm); 
const search = ref('')
const filterTableData = computed(() =>
  productList.value.filter(
    (data) =>
      !search.value ||
      data.name.toLowerCase().includes(search.value.toLowerCase())
  )
)

const { proxy }: any = getCurrentInstance();

const state = reactive({
  // 遮罩层
  loading: true,
  // 选中数组
  ids: [] as number[],
  // 总条数
  total: 0,
  productList: [],
  dialog: {
    visible: false
  } as DialogType,
  queryParams: {
    pageNum: 1,
    pageSize: 10
  } ,
  rules: {
  },

  importDialog: {
    title: 'Product Import',
    visible: false
  } as DialogType,
  importFormData: {},
  excelFile: undefined as any,
  excelFilelist: [] as File[]
});

const {
  ids,
  loading,
  queryParams,
  productList,
  total,
  dialog,
  rules,
  importDialog,
  importFormData,
  excelFilelist
} = toRefs(state);

/**
 * handle query
 */
function handleQuery() {
  state.loading = true;
  listProducts(state.queryParams).then(({ data }) => {
    state.productList = data.data;
    state.total = data.meta.total;
    state.loading = false;
  });
}

function handleSelectionChange(selection: any) {
  state.ids = selection.map((item: any) => item.id);
}

/**
 * download sample excel
 */
function handleDownloadTemplate() {
  downloadTemplate().then((response: any) => {
    const blob = new Blob([response.data], {
      type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'
    });
    const a = document.createElement('a');
    const href = window.URL.createObjectURL(blob); // 下载链接
    a.href = href;
    a.download = decodeURI(
      response.headers['content-disposition'].split(';')[1].split('=')[1]
    ); // 获取后台设置的文件名称
    document.body.appendChild(a);
    a.click(); // 点击下载
    document.body.removeChild(a); // 下载完成移除元素
    window.URL.revokeObjectURL(href); // 释放掉blob对象
  });
}

/**
 * show import
 */
async function showImportDialog() {
  importDialog.value.visible = true;
}

/**
 * handle excel change
 *
 * @param file
 */
function handleExcelChange(file: UploadFile) {
  if (!/\.(xlsx|xls|XLSX|XLS)$/.test(file.name)) {
    ElMessage.warning('upload file must be Excel format ex: xlsx, xls');
    state.excelFile = undefined;
    state.excelFilelist = [];
    return false;
  }
  state.excelFile = file.raw;
}

/**
 * upload file
 */
function submitImportForm() {
  importFormRef.value.validate((valid: any) => {
    if (valid) {
      if (!state.excelFile) {
        ElMessage.warning('import excel file cannot be empty');
        return false;
      }

      importProducts(state.excelFile).then(response => {
        ElMessage.success(response.data);
        closeImportDialog();
        handleQuery();
      });
    }
  });
}

/**
 * close import dialog
 */
function closeImportDialog() {
  state.importDialog.visible = false;
  state.excelFile = undefined;
  state.excelFilelist = [];
  importFormRef.value.resetFields();
}

onMounted(() => {
  handleQuery();
});
</script>

<style lang="scss">
html.base-theme .el-button + .el-button {
  margin-left: 0;
}
</style>