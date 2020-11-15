<footer class="text-center border-top py-4">
  <p>Copyright ©️ 2020 <span id='sure'>Sure</span></p>
  <a href="https://github.com/LucasVinicius314" target="blank">Github</a>
</footer>

<script>
  const sure = document.querySelector('#sure')
  let x = 0
  setInterval(() => {
    sure.setAttribute('style', `color: hsl(${x++ % 255}, 50%, 50%)`)
  }, 1 / 60)
</script>