<template>
  <div class="grid-x grid-margin-x align-top">
    <div class="cell medium-3 content-list-wrap">
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
          <li @click="component = element" :class="{ active: component === element }">
            <i class="fal fa-align-justify handle"></i>
            {{ element.name }}
            <button type="button" @click="remove(index)">
              <i class="fal fa-times close"></i>
            </button>
          </li>
        </template>
      </draggable>

      <button class="button expanded margin-bottom-0" type="button"
              @click="showModuleOptions = !showModuleOptions">
        Add module
        <i class="fal fa-plus"></i>
      </button>

      <div id="add-module-menu" v-if="showModuleOptions">
        <a v-for="(o, m) in modules" @click="add(o, m)">
          <i :class="'fal fa-' + o.icon"></i>
          {{ o.name }}
        </a>
      </div>
    </div>

    <div class="cell medium-9 content-edit-module-wrap">
      <section class="content-edit-module" v-if="component" :key="component.id">
        <component
            :is="component.module"
            :key="component.id"
            :id="component.id"
            :fields="component.fields"
            @update-content="update"
        ></component>
      </section>
      <section class="content-edit-module content-edit-module-default" v-else>
        <h3>Click on a module's handle and drag to re-order</h3>
        <h4>Select a module to edit content</h4>
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
    json(c = 'content') {
      return JSON.stringify(this[c]);
    },
    remove(i) {
      this.content.splice(i, 1);
      this.component = null;
    },
    add(o, m) {
      const c = _.cloneDeep(o);

      const component = {
        id: uuidv4(),
        module: m,
        name: c.name,
        fields: c.fields,
        show: true
      };

      this.content.push(component);
      this.showModuleOptions = false;
      this.component = component;
    },
    update(a) {
      const i = _.findIndex(this.content, (o) => {
        return o.id === a[0];
      });

      Object.keys(this.dynamicContent).forEach((key) => {
        if (this.dynamicContent[key].id === a[0]) {
          return this.dynamicContent[key].fields[a[1]].value = a[2];
        }
      })

      if (i === -1) {
        return;
      }

      if (typeof this.content[i].fields[a[1]] === 'undefined') {
        this.content[i].fields[a[1]] = {
          value: a[2]
        }
      }

      return this.content[i].fields[a[1]].value = a[2];
    },
    isEmpty(o) {
      return _.isEmpty(o);
    }
  }
}
</script>
