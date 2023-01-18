<template>
  <div class="flex space-x-4">
    <div class="w-1/3">
      <template v-if="!isEmpty(dynamicContent)">
        <h5>Dynamic page content</h5>
        <ul class="menu-list">
          <li v-for="(o, m) in dynamicContent">
            <a @click="component = o">
              {{ o.name }}
            </a>
          </li>
        </ul>
        <hr/>
      </template>

      <draggable
          tag="ul"
          class="content-list no-bullet"
          :list="content"
          v-bind="animate"
          @start="drag=true"
          @end="drag=false"
          handle=".handle"
          item-key="id"
      >
        <template #item="{element, index}">
          <li class="list-item" @click="component = element" :class="{ active: component === element }">
            <div class="">
            <i class="mr-2 fal fa-align-justify cursor-handle"></i>
              {{ element.name }}
            </div>
            <button type="button" @click="remove(index)">
            <i class="mr-2 fal fa-close"></i>
            </button>
          </li>
        </template>
      </draggable>

      <button class="w-full btn btn-primary" type="button" @click="showModuleOptions = !showModuleOptions">
        Add module
        <i class="fal fa-plus"></i>
      </button>

      <div v-if="showModuleOptions" id="add-module-menu" class="grid grid-cols-2 gap-4 p-4 bg-gray-100">
        <a v-for="(module, moduleName) in modules" @click="add(module, moduleName)" :key="module" class="w-full btn btn-primary-outlined">
          <i :class="'fal fa-' + module.icon"></i>
          {{ module.name }}
        </a>
      </div>
    </div>

    <div class="w-2/3">

      <section class="p-4 bg-gray-100 rounded content-edit-module" v-if="component" :key="component.id">
        <div>
          <div>
            <header class="pb-2 mb-4 border-b border-gray-400 flex justify-between">
              <h3 class="">{{ component.name }}</h3>
              <div v-if="component.templates.length > 1" class="space-x-4">
                <span>Template:</span>
                <select>
                  <option v-for="template in component.templates" :value="template">
                    {{ template }}
                  </option>
                </select>
              </div>
            </header>
          </div>

          <component
              :is="component.module"
              :key="component.id"
              :id="component.id"
              :fields="component.fields"
              @update-content="update"
          ></component>
        </div>
      </section>

      <section class="flex items-center justify-center w-full p-4 text-center border h-60 border-brand-almond-200" v-else>
        <div>
          <h4>Click on a module's handle and drag to re-order</h4>
          <h6>Select a module to edit content</h6>
        </div>
      </section>

    </div>

    <!--        <pre>{{ content }}</pre>-->
    <input type="hidden" name="content" :value="json()"/>
    <input type="hidden" name="dynamic_content" :value="json('dynamicContent')"/>
  </div>
</template>
<script>
import Draggable from 'vuedraggable';
import { v4 as uuidv4 } from 'uuid';

export default {
  components: {
    Draggable,
  },
  props: {
    modules: Object,
    dynamicModules: {
      type: Object,
      default: null
    },
    pageContent: Array
  },
  data() {
    return {
      content: [],
      dynamicContent: {},
      showModuleOptions: false,
      component: null
    }
  },
  created() {
    if (this.pageContent.length) {
      this.content = _.cloneDeep(this.pageContent);
    }

    if (!this.isEmpty(this.dynamicModules)) {
      this.dynamicContent = _.cloneDeep(this.dynamicModules);
    }
  },
  computed: {
    animate() {
      return {
        animation: 200,
        disabled: false,
        ghostClass: 'ghost'
      }
    },
  },
  methods: {
    json(prop = 'content') {
      return JSON.stringify(this[prop]);
    },
    remove(index) {
      this.content.splice(index, 1);
      this.component = null;
    },
    add(module, name) {
      const component = {
        id: uuidv4(),
        module: name,
        show: true,
        ...module,
      };

      this.content.push(component);
      this.showModuleOptions = false;
      this.component = component;
    },
    update(payload) {
      const [uuid, prop, value] = payload;

      const i = _.findIndex(this.content, (module) => {
        return module.id === uuid;
      });

      // Object.keys(this.dynamicContent).forEach((key) => {
      //   if (this.dynamicContent[key].id === uuid) {
      //     return this.dynamicContent[key].fields[prop].value = value;
      //   }
      // })

      if (i === -1) {
        return;
      }

      this.content[i].fields[prop] = {
        ...this.content[i].fields[prop],
        value,
      };
    },
    isEmpty(object) {
      return _.isEmpty(object);
    }
  }
}
</script>

<style lang="postcss" scoped>
.list-item {
  @apply flex items-center justify-between py-2 px-4 border border-gray-200 mb-4 rounded;
}
</style>
