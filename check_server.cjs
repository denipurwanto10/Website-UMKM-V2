(async () => {
  try {
    const res = await fetch('http://localhost:5173');
    console.log('status:', res.status);
  } catch(e) {
    console.log('error:', e.message);
  }
})();