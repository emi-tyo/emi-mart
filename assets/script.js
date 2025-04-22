document.addEventListener('DOMContentLoaded', () => {
    const qtyInputs = document.querySelectorAll('.qty');
    const totalEl = document.getElementById('total');
  
    function updateTotals() {
      let total = 0;
  
      qtyInputs.forEach(input => {
        const price = parseFloat(input.dataset.price);
        const quantity = parseInt(input.value);
        const subtotal = price * quantity;


        const subtotalElem = input.closest('tr').querySelector('.subtotal');
        subtotalElem.textContent = `$${subtotal.toFixed(2)}`;
  

        total += subtotal;
      });
  

      if (totalEl) {
        totalEl.textContent = total.toFixed(2);
      }
    }
  
    // 数量入力変更時に更新
    qtyInputs.forEach(input => {
      input.addEventListener('input', updateTotals);
    });
  });
  