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

#ifndef PHP_XHPROF_WIN32_H
#define PHP_XHPROF_WIN32_H


/****************************************************************************

    windows specific data-type, definitions, ...

****************************************************************************/
#include <windows.h>

#ifdef _MSC_VER
    typedef __int32 int32_t;
    typedef unsigned __int32 uint32_t;
    typedef __int64 int64_t;
    typedef unsigned __int64 uint64_t;
#else
    #include <stdint.h>
#endif

#if !defined(uint64)
    typedef unsigned __int64 uint64;
#define uint64 uint64
#endif


/****************************************************************************

  sysconf() replacement win32 = sysinfo()

****************************************************************************/
SYSTEM_INFO sysinfo;


/****************************************************************************

    cpu_set_t

****************************************************************************/
#if !defined(cpu_set_t)
    typedef unsigned long cpu_set_t;
#endif


/****************************************************************************

    rusage

****************************************************************************/
#ifdef WIN32
#include <time.h>               /* for struct timeval */
#endif
#ifndef WIN32
#include <sys/time.h>           /* for struct timeval */
#include <sys/times.h>          /* for struct tms */
#endif
#include <limits.h>             /* for CLK_TCK */

#define RUSAGE_SELF     0
#define RUSAGE_CHILDREN (-1)

struct rusage {
    struct timeval ru_utime;    /* user time used */
    struct timeval ru_stime;    /* system time used */
};

extern int getrusage(int who, struct rusage * rusage);


#endif  /* PHP_XHPROF_WIN32_H */
