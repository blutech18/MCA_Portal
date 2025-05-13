<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Classes</title>
  <link rel="stylesheet" href="{{ asset('css/style_admin_courses.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
        <img src="{{ asset('images/schoollogo.png') }}" alt="School Logo" class="logo">
        <h2>MCA Montessori School</h2>
        <nav class="menu">
          <ul>
            <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}" class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">Users</a></li>
            <li>
              <a href="#" onclick="toggleSubMenu(event)">Instructors ▾</a>
              <ul class="submenu hidden">
                <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">All Instructors</a></li>
                <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'activee' : '' }}">Subjects</a></li>
                <li><a href="{{ route('admin.courses.index') }}" class="{{ Route::currentRouteName() == 'admin.courses.index' ? 'active' : '' }}">Courses</a></li>
              </ul>
            </li>
            <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Students & Sections</a></li>
            <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
          </ul>
        </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">

          <header class="top-bar">
            <div class="welcome"><h3>Manage Enrollees</h3></div>
            <div class="user-info">
              <img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon">
            </div>
          </header>
        
          <div class="container-classes">
            <div class="strand-box">
              <div class="courses-list mb-4 flex justify-between items-center">
                <h2>Enrollees Info</h2>
                <div class="relative w-full max-w-xs">
                  <select id="enrollee-filter"
                          class="custom-select"
                          onchange="toggleLists(this.value)">
                    <option value="" disabled selected>-- Enrollee Type --</option>
                    <option value="new">New Students</option>
                    <option value="old">Old Students</option>
                  </select>
                </div>
              </div>
              
              <div id="enrollee-modal"
                class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                <div class="absolute top-1/2 left-1/2
                            transform -translate-x-1/2 -translate-y-1/2
                            bg-white rounded-lg shadow-lg
                            w-11/12 md:w-2/3 max-h-[90vh] overflow-hidden">
                  <div id="enrollee-modal-content"
                      class="overflow-auto max-h-[85vh]"></div>
                </div>
              </div>
            </div>
          </div>

          <div id="new-enrollees-section" class="container-classes  hidden">
            <div class="strand-box">
              <div class="courses-list">
                <h2>New Student Enrollees</h2>
                <input type="text"
                       id="instructor-search"
                       class="search-bar2"
                       placeholder="Search…">
              </div>
        
              <table class="enrollee-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>LRN No.</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Previous Grade</th>
                    <th>Strand</th>
                    <th colspan="2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($newEnrollees as $e)

                
                  <tr>
                    {{-- Combine surname, given, middle --}}
                    <td>{{ $e->surname }}, {{ $e->given_name }} {{ $e->middle_name }}</td>
                    <td>{{ $e->lrn ?? '–' }}</td>
                    <td>{{ $e->contact_no }}</td>
                    <td>{{ $e->email }}</td>
                    <td>{{ $e->previous_grade }}</td>
                    <td>{{ $e->strand ?? '–' }}</td>
                    <td>
                      <button
                        type="button"
                        data-url="{{ route('admin.enrollee.new.modal', $e->id) }}"
                        class="btn view-btn"
                      >Info</button>
                    </td>
                    <td>
                      <form action="{{ route('admin.enrollees.destroy', $e) }}" method="POST" onsubmit="return confirm('Delete this enrollee?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn delete-btn">Delete</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
                </tbody>
                
              </table>
            </div>
          </div>

          <div id="old-enrollees-section" class="container-classes  hidden">
            <div class="strand-box">

              <div class="courses-list mb-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Old Student Enrollees</h2>
                <input type="text"
                      id="old-enrollee-search"
                      class="search-bar2"
                      placeholder="Search…">
              </div>

              <table class="enrollee-table w-full">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>LRN</th>
                    <th>Applying Grade</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($oldEnrollees as $e)
                    <tr>
                      <td>{{ $e->student_id }}</td>
                      <td>{{ $e->surname }}, {{ $e->given_name }} {{ $e->middle_name }}</td>
                      <td>{{ $e->lrn }}</td>
                      <td>{{ $e->grade_level_applying ?? '–' }}</td>
                      <td class="space-x-2">
                        <button
                          type="button"
                          data-url="{{ route('admin.enrollee.old.modal', $e->id) }}"
                          class="btn view-btn bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded"
                        >
                          Info
                        </button>
                        <form
                          action="{{ route('admin.old.enrollees.destroy', $e->id) }}"
                          method="POST"
                          class="inline-block"
                          onsubmit="return confirm('Delete this enrollee?')"
                        >
                          @csrf
                          @method('DELETE')
                          <button class="btn delete-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                            Delete
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center py-4">No old-student enrollees yet.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>

              {{-- Shared modal container --}}
              <div id="enrollee-modal"
                  class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                <div class="absolute top-1/2 left-1/2
                            transform -translate-x-1/2 -translate-y-1/2
                            bg-white rounded-lg shadow-lg
                            w-11/12 md:w-2/3 max-h-[90vh] overflow-hidden">
                  <div id="enrollee-modal-content"
                      class="overflow-auto max-h-[85vh] p-4"></div>
                </div>
              </div>

            </div>
          </div>

        </main>
    </div>

    <script>
      document.getElementById('instructor-search').addEventListener('keyup', function(){
        const term = this.value.toLowerCase();
        document.querySelectorAll('.enrollee-table tbody tr').forEach(row => {
          row.style.display = row.textContent.toLowerCase().includes(term)
                              ? '' : 'none';
        });
      });
    </script>

    <script src="{{ asset('js/script_admin_course.js') }}"></script>
    
    <script>
      function toggleSubMenu(event) {
          event.preventDefault();
          const submenu = event.target.nextElementSibling;
          submenu.classList.toggle('hidden');
        }
    </script>

    <script>

      document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.view-btn').forEach(btn => {
          btn.addEventListener('click', async e => {
            e.preventDefault();
            const url = btn.dataset.url;
            console.log('Opening modal, fetching', url);

            try {
              const res  = await fetch(url);
              if (!res.ok) throw new Error(`HTTP ${res.status}`);
              const html = await res.text();

              const modal   = document.getElementById('enrollee-modal');
              const content = document.getElementById('enrollee-modal-content');

              content.innerHTML = html;

              // show the modal
              modal.classList.remove('hidden');
              modal.style.display = 'block';

              // close handlers
              content.querySelector('.modal-close').onclick = () => {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                content.innerHTML = '';
              };
              modal.onclick = ev => {
                if (ev.target === modal) {
                  modal.classList.add('hidden');
                  modal.style.display = 'none';
                  content.innerHTML = '';
                }
              };
            } catch (err) {
              console.error('Modal fetch failed:', err);
              alert('Could not load enrollee details. See console.');
            }
          });
        });

        const filter = document.getElementById('enrollee-filter');
        const newSection = document.getElementById('new-enrollees-section');
        const oldSection = document.getElementById('old-enrollees-section');

        filter.addEventListener('change', function () {
          if (this.value === 'new') {
            newSection.classList.remove('hidden');
            oldSection.classList.add('hidden');
          } else {
            oldSection.classList.remove('hidden');
            newSection.classList.add('hidden');
          }
        });
      });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</body>
</html>
