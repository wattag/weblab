@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-violet-500 dark:focus:ring-violet-500 rounded-xl shadow-sm transition-colors']) }}>
