document.addEventListener("DOMContentLoaded", () => {
  const isBookmarksPage = window.location.pathname.includes("bookmarks.html");
  if (isBookmarksPage) {
    loadBookmarks();
  } else {
    loadJobs();
  }
});

function createJobCard(job) {
  const card = document.createElement("div");
  card.classList.add("job-card");

  let deadlineText = "3 days remaining";
  if (job.deadline && job.deadline !== "undefined") {
    const deadlineDate = new Date(job.deadline);
    const now = new Date();
    const diffTime = deadlineDate - now;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays > 0) {
      deadlineText = `${diffDays} days remaining`;
    } else {
      deadlineText = "Deadline expired";
    }
  }

  card.innerHTML = `
    <div class="d-flex justify-content-between flex-wrap">
      <span class="text-muted small mb-2">
        <i class="bi bi-clock"></i> ${job.posted_time || "Unknown time"}
      </span>
      <span class="text-muted small mb-2">
        <i class="bi bi-eye"></i> ${job.views || "0"} views
      </span>
    </div>

    <h5 class="fw-bold mt-2">${job.title}</h5>

    <div class="d-flex align-items-center mb-3">
      <img src="${
        job.company_logo
      }" class="rounded-circle me-2 company-logo" alt="company-logo" />
      <small>${job.company}</small>
    </div>

    <div class="row g-2 mb-3">
      <div class="col-md-auto">
        <span class="badge bg-light text-dark px-3 py-2">${
          job.category || "undefined"
        }</span>
      </div>
      <div class="col-md-auto">
        <span class="badge bg-light text-dark px-3 py-2">${
          job.salary || "undefined"
        }</span>
      </div>
      <div class="col-md-auto">
        <span class="badge bg-light text-dark px-3 py-2">${
          job.experience || "undefined"
        }</span>
      </div>
      <div class="col-md-auto">
        <span class="badge bg-light text-dark px-3 py-2">${deadlineText}</span>
      </div>
    </div>

    <p class="text-muted">${job.description || "No description"}</p>

    <div class="d-flex flex-wrap">
      ${
        job.skills && job.skills.length > 0
          ? job.skills
              .map((skill) => `<span class="skill-badge">${skill}</span>`)
              .join("")
          : ""
      }
    </div>
  `;

  const button = document.createElement("button");
  button.className = "btn-save btn mt-3";
  button.innerHTML = job.favorite
    ? '<i class="bi bi-bookmark-check-fill"></i> Saved'
    : '<i class="bi bi-bookmark"></i> Save';

  if (job.favorite) {
    button.classList.add("saved");
  }

  button.addEventListener("click", async (event) => {
    event.stopPropagation();
    await toggleFavorite(job.id, button);
  });

  card.appendChild(button);

  card.addEventListener("click", () => {
    window.location.href = `details.html?id=${job.id}`;
  });

  return card;
}

async function loadJobs() {
  const container = document.getElementById("jobs-container");
  container.innerHTML = "";

  try {
    const res = await fetch(
      "http://localhost:8000/api/ar/api/job-seeker/all-jobs"
    );
    const jobs = await res.json();

    jobs.forEach((job) => {
      const skillsArray = Array.isArray(job.skills)
        ? job.skills
        : job.skills
        ? job.skills.split(",").map((s) => s.trim())
        : [];

      const jobData = {
        id: job.id,
        title: job.title,
        company: job.company_name || "undefined",
        company_logo: job.company_logo || "./assets/images/default-logo.png",
        category: job.category || "undefined",
        salary: job.salary || "undefined",
        experience: job.work_experience
          ? `${job.work_experience} Years`
          : "undefined",
        deadline: job.deadline || "undefined",
        description: job.description || "No description",
        skills: skillsArray,
        posted_time: job.posted_time || "Unknown time",
        views: job.views || "0",
        favorite: job.favorite || false,
      };

      const card = createJobCard(jobData);
      container.appendChild(card);
    });
  } catch (error) {
    container.textContent = "An error occurred while loading jobs.";
    console.error(error);
  }
}

async function loadBookmarks() {
  const container =
    document.getElementById("bookmarks-container") ||
    document.getElementById("jobs-container");
  container.innerHTML = "";

  try {
    const res = await fetch(
      "http://localhost:8000/api/ar/api/job-seeker/bookmarks"
    );
    const bookmarks = await res.json();

    bookmarks.forEach((job) => {
      const skillsArray = Array.isArray(job.skills)
        ? job.skills
        : job.skills
        ? job.skills.split(",").map((s) => s.trim())
        : [];

      const jobData = {
        id: job.id,
        title: job.title,
        company: job.company_name || "undefined",
        company_logo: job.company_logo || "./assets/images/default-logo.png",
        category: job.category || "undefined",
        salary: job.salary || "undefined",
        experience: job.work_experience
          ? `${job.work_experience} Years`
          : "undefined",
        deadline: job.deadline || "undefined",
        description: job.description || "No description",
        skills: skillsArray,
        posted_time: job.posted_time || "Unknown time",
        views: job.views || "0",
        favorite: true,
      };

      const card = createJobCard(jobData);
      container.appendChild(card);
    });
  } catch (error) {
    container.textContent = "Error loading bookmarks.";
    console.error(error);
  }
}

async function toggleFavorite(jobId, button) {
  try {
    const res = await fetch(
      `http://localhost:8000/api/jobs/${jobId}/mark-favorite`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      }
    );

    if (res.ok) {
      const isSaved = button.classList.contains("saved");

      if (isSaved) {
        button.innerHTML = '<i class="bi bi-bookmark"></i> Save';
        button.classList.remove("saved");
        alert("Job removed from favorites.");

        // لو في صفحة المفضلة، نحذف البطاقة بدون إعادة تحميل
        if (window.location.pathname.includes("bookmarks.html")) {
          button.closest(".job-card")?.remove();
        }
      } else {
        button.innerHTML = '<i class="bi bi-bookmark-check-fill"></i> Saved';
        button.classList.add("saved");
        alert("Job added to favorites.");
      }
    } else {
      alert("Failed to toggle favorite.");
    }
  } catch (error) {
    alert("An error occurred while toggling favorite.");
    console.error(error);
  }
}
