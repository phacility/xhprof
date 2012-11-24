/****************************************************************************
 *
 *  Copyright (c) 2010 - 2012 Benjamin Carl
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 ***************************************************************************/

int getrusage(int who, struct rusage * rusage)
{
    FILETIME starttime;
    FILETIME exittime;
    FILETIME kerneltime;
    FILETIME usertime;
    ULARGE_INTEGER li;

    if (who != RUSAGE_SELF) {
        // Only RUSAGE_SELF is supported in this implementation for now
        errno = EINVAL;
        return -1;
    }

    if (rusage == (struct rusage *) NULL)
    {
        errno = EFAULT;
        return -1;
    }

    memset(rusage, 0, sizeof(struct rusage));

    if (GetProcessTimes(GetCurrentProcess(),
                        &starttime, &exittime, &kerneltime, &usertime) == 0)
    {
        return -1;
    }

    /* Convert FILETIMEs (0.1 us) to struct timeval */
    memcpy(&li, &kerneltime, sizeof(FILETIME));
    li.QuadPart /= 10L;         /* Convert to microseconds */
    rusage->ru_stime.tv_sec = (long)li.QuadPart / 1000000L;
    rusage->ru_stime.tv_usec = (long)li.QuadPart % 1000000L;

    memcpy(&li, &usertime, sizeof(FILETIME));
    li.QuadPart /= 10L;         /* Convert to microseconds */
    rusage->ru_utime.tv_sec = (long)li.QuadPart / 1000000L;
    rusage->ru_utime.tv_usec = (long)li.QuadPart % 1000000L;


    // success
    return 0;
}
