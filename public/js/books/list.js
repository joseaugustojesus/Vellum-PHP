const confirm = new (function () {
  this.destroy = (element) => {
    let id = element.dataset.id;
    let endpoint = `${APP_URL}` + "/books/delete/" + id;
    notificationsToast("warning", `Deseja remover o livro? <a href='${endpoint}' class='btn btn-sm btn-danger'>Deletar</a>`);
  };
})();