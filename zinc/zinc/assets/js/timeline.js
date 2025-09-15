document.addEventListener('DOMContentLoaded', function () {
  // کاهش انیمیشن برای کاربرانی که prefers-reduced-motion فعال دارند
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('.timeline-text').forEach(t => {
      t.classList.remove('opacity-0','translate-x-6');
      t.classList.add('opacity-100','translate-x-0');
    });
    document.querySelectorAll('.timeline-circle').forEach(c => {
      c.classList.remove('t-scale-0-c');
      c.classList.add('t-scale-1-c');
    });
    document.querySelectorAll('.timeline-line').forEach(l => {
      l.classList.remove('t-scale-0');
      l.classList.add('t-scale-1');
    });
    return;
  }

  const rows = Array.from(document.querySelectorAll('.timeline-row'));
  const observerOptions = {
    root: null,
    rootMargin: '0px 0px -12% 0px', // وقتی کمی بالاتر از پایان آیتم، فعال شود
    threshold: 0.15
  };

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const row = entry.target;
      const index = rows.indexOf(row);

      const text = row.querySelector('.timeline-text');
      const circle = row.querySelector('.timeline-circle');
      const line = row.querySelector('.timeline-line');

      // stagger با تأخیر بر اساس ایندکس
      const delay = index * 140;

      setTimeout(() => {
        // متن: از opacity-0 + translate-x-6 به نمایش کامل
        if (text) {
          text.classList.remove('opacity-0','translate-x-6');
          text.classList.add('opacity-100','translate-x-0');
        }

        // دایره: pop
        if (circle) {
          circle.classList.remove('t-scale-0-c');
          circle.classList.add('t-scale-1-c');
        }

        // خط: رشد از بالا به پایین
        if (line) {
          line.classList.remove('t-scale-0');
          line.classList.add('t-scale-1');
        }
      }, delay);

      // فقط یک بار انیمیشن می‌خواهیم
      obs.unobserve(row);
    });
  }, observerOptions);

  rows.forEach(r => observer.observe(r));
});
