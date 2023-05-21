<template>
  <div id="tarefa">
    <div>
      <h1>ToDo List</h1>

      <div class="cont-btn">
        <button on @click="onOpenModalTodoAdd()">Adicionar</button>
      </div>

      <!-- {{todos}} -->

      <div v-if="isLoading">Carregando...</div>

      <div class="todo" v-else>
        <div v-for="todo in todos" :key="todo.id" class="todo-item" :class="{isLoading: todo.isLoading}">
          <div class="todo-item-actions">
            <input type="checkbox" class="todo-item-is-done" v-model="todo.concluido" @change="onCheckTodo(todo.id)" />
          </div>
          <div class="todo-item-titulo">
            {{todo.titulo}}
          </div>
          <div class="todo-item-actions">
            <button class="todo-item-edit" @click="onOpenModalTodoEdit(todo.id)">Editar</button>
            <button class="todo-item-remove" @click="onRemoveTodo(todo.id)"> X </button>
          </div>
        </div>
      </div>

      <b-modal
        id="todo-modal"
        ref="modal"
        titulo="Adicionar tarefa"
        @ok="submitForm"
      >
        <form ref="form">
          <input type="checkbox" v-model="form.concluido" />
          <input type="text" placeholder="Título" v-model="form.titulo" />
          <textarea v-model="form.descricao" placeholder="Descrição"></textarea>
        </form>
      </b-modal>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    async submitForm() {
      if(this.form.id) {
        const index = this.getIndexFromId(this.form.id)
        const response = await fetch(`http://127.0.0.1:8000/tarefas/${this.form.id}`, {
          method: 'PUT',
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(this.form)
        })

        console.log('response PUT -> ', response)
        this.todos.splice(index, 1, this.form)
        return;
      }

      const response = await fetch('http://127.0.0.1:8000/tarefas/', {
        method: 'POST',
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({titulo : this.form.titulo, descricao : this.form.descricao, concluido : this.form.concluido})
      })
      console.log('response POST -> ', response)
      this.todos.push(this.form)

    },
    onOpenModalTodoAdd() {
      this.$bvModal.show('todo-modal')
      this.form = {
        id: 0,
        titulo: '',
        descricao: '',
        concluido: false,
        isLoading: false,
      }
    },
    async onCheckTodo(id) {
      const concluido = this.getTodoFromId(id);

      this.updateTodoItem(id, { isLoading: true });

      const response = await fetch(`http://127.0.0.1:8000/tarefas/${id}`, {
        method: 'PUT',
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify( concluido )
      });

      console.log('response concluido -> ', response);
      this.updateTodoItem(id, { isLoading: false });
      return;
    },
    onOpenModalTodoEdit(id) {
      this.$bvModal.show('todo-modal')
      this.form = this.getTodoFromId(id)
    },
    updateTodoItem(id, update) {
      const tempTodos = [...this.todos];
      const index = this.getIndexFromId(id)
      tempTodos[index] = Object.assign({}, this.getTodoFromId(id), update)
      this.todos = [...tempTodos];
    },
    async onRemoveTodo(id) {
      const tempTodos = [...this.todos];
      const index = this.getIndexFromId(id)
      tempTodos.splice(index, 1);

      this.updateTodoItem(id, { isLoading: true });
      const response = await fetch(`http://127.0.0.1:8000/tarefas/${id}`, {
        method: 'DELETE'
      });
      this.updateTodoItem(id, { isLoading: false });

      console.log('response DELETE -> ', response);

      this.todos = [...tempTodos];
    },
    getIndexFromId(id) {
      return this.todos.findIndex(t => t.id === id)
    },
    getTodoFromId(id) {
      return {...this.todos.find(t => t.id === id)}
    }
  },
  created() {
    (async () => {
      this.isLoading = true;
      this.todos = await fetch('http://127.0.0.1:8000').then(response => response.json())
      this.isLoading = false;
    })()
  },
  data: () => ({
    formIndex: null,
    form: {
      id: 0,
      titulo: '',
      descricao: '',
      concluido: false,
      isLoading: false
    },
    isLoading: false,
    todos: []
  })
}
</script>


<style scoped>
  body {
    background: #ededed!important;
  }

  #tarefa {
    display: flex;
    width: 100%;
    justify-content: center;
    margin-top: 20px;
  }

  #tarefa > div {
    width: 50%;
    background-color: #FFFFFF;
    padding: 10px;
    border-radius: 10px;
  }

  #tarefa button {
    border: none;
    padding: 5px;
    border-radius: 5px;
    background-color: #28a745;
    color: #FFFFFF;
  }

  #tarefa button:hover {
    opacity: 0.8;
  }

  .cont-btn {
    text-align: right;
    margin-right: 30px;
  }

  h1 {
    text-align: center;
    font-weight: 600;
    margin-bottom: 50px;
  }

  form {
    display: flex;
    width: 100%;
    flex-wrap: wrap;
  }
  
  input[type=checkbox] {
    width: 20px;
    margin-right: 10px;
  }

  input[type=text] {
    outline-style: none;
    width: calc(100% - 30px);
  }

  textarea {
    width: 100%;
    outline-style: none;
    resize: none;
    margin-top: 20px;
  }

  .todo {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 1rem;
    border-top: 1px solid #ededed;
    margin-top: 10px; 
  }

  .todo-item {
    display: flex;
    padding: 0.5rem 1rem;
    border-bottom: 1px solid #c9c9c9;
    align-items: center;
  }

  .todo-item-edit {
      border: 1px solid #17a2b8!important;
      background: transparent!important;
      color: #17a2b8!important;
      margin-right: 10px;
  }

  .todo-item-edit:hover {
      background-color: #17a2b8!important;
      color: #FFFFFF!important;
  }

  .todo-item-remove {
    background-color: #dc3545!important;
    padding: 5px 20px!important;
  }

  .todo-item-titulo {
    flex: 1;
    padding-left: 1rem;
  }
</style>